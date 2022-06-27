<?php

namespace App\Http\Controllers;

use App\Models\Workorder;
use App\Models\WorkorderChangedPieces;
use App\Models\Piece;
use App\Models\Client;
use App\Models\User;
use App\Models\WorkorderState;
use App\Models\Photo;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\SignInResult\SignInResult;
use Kreait\Firebase\Exception\FirebaseException;
use Google\Cloud\Firestore\FirestoreClient;
use Session;

use PDF;
use Illuminate\Support\Facades\File;

class WorkorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $workorders = Workorder::query()->orderBy('id');
        $states = WorkorderState::all()->sortBy('id');
        $clients = Client::all()->sortBy('id');
        $users = User::all()->sortBy('id');


        if ($request->has('id') && $request->id) {
            $workorders->where('id', $request->id);
        }

        if ($request->has('first_name') && $request->first_name) { 
            $selectedclients = Client::query()->where('first_name','ilike', "%$request->first_name%")
            ->orWhere('last_name', 'ilike', "%$request->first_name%" )
            ->orWhere(DB::raw("CONCAT(first_name,' ',last_name)"), 'ilike', '%'.$request->first_name.'%')                    
            ->pluck('id');
            $workorders->whereIn('client_id', $selectedclients);
        }

        if ($request->has('state_id') && $request->state_id) {
            $selectedWorkorderStates = WorkorderState::query()->where('description','ilike', "%$request->state_id%")
            ->pluck('id');
            $workorders->whereIn('state_id', $selectedWorkorderStates );
        }

        if ($request->has('user_id') && $request->user_id) {
            $selectedUsers = User::query()->where('first_name','ilike', "%$request->user_id%")
            ->orWhere('last_name', 'ilike', "%$request->user_id%" )        
            ->orWhere(DB::raw("CONCAT(first_name,' ',last_name)"), 'ilike', '%'.$request->user_id.'%')  
            ->pluck('id');
            $workorders->whereIn('user_id', $selectedUsers);
        }

      
        if ($request->has('car_initial_date') && $request->car_initial_date) {
            $workorders->where('car_initial_date', 'ilike', "%$request->car_initial_date%");
        }
        
        if ($request->has('car_final_date') && $request->car_final_date) {
            $workorders->where('car_final_date', 'ilike', "%$request->car_final_date%");
        }
        

        return view('workorders.index', ['workorders' => $workorders->paginate(10),
        'states' => $states,
        'clients' => $clients,
        'users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = WorkorderState::all()->sortBy('id');
        $clients = Client::all()->sortBy('id');
        return view('workorders.create', [
            'states' => $states,
            'clients' => $clients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'state_id' => 'required',
            'user_id' => 'required',
            'car_initial_state' => 'required',
            'car_initial_date' => 'required'
        ]);

        Workorder::create($request->all());
        alert()->success('Successfull','The workorder has been saved');
        return redirect('/workorders');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function show(Workorder $workorder)
    {
        //
    }



    public function pieces_list(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            WorkorderChangedPieces::create($request->all());
            $piece = Piece::find($request->piece_id);
            $piece_quantity = DB::table('pieces')->where('id', $request->piece_id)->value('quantity');
            $r = $piece_quantity - $request->quantity;
            $piece->update(['quantity' => $r]);
            alert()->success('Successfull','The piece has been added to workorder');
            return redirect("/workorders/$id/pieces_list");
        }
        $workorder = Workorder::find($id);
        $pieces = Piece::all()->where('is_active', true)->sortBy('id');
        $pieces_workorder = WorkorderChangedPieces::where('workorder_id', $workorder->id)->get();
        return view('workorders.pieces_list', [
            'workorder' => $workorder,
            'pieces_workorder' => $pieces_workorder,
            'pieces' => $pieces
        ]);
    }

    public function removePiece(Request $request)
    {
        $piece_id = DB::table('workorder_changed_pieces')->where('id', $request->id)->value('piece_id');
        $piece = Piece::find($piece_id);
        $piece_quantity = DB::table('pieces')->where('id', $piece_id)->value('quantity');
        $piece_quantity2 = DB::table('workorder_changed_pieces')->where('id', $request->id)->value('quantity');
        $r = $piece_quantity + $piece_quantity2;
        $piece->update(['quantity' => $r]);

        WorkorderChangedPieces::where(['id' => $request->id, 'workorder_id' => $request->workorder_id])->delete();
        alert()->success('Successfull','The piece has been removed of workorder');
        return redirect("/workorders/$request->workorder_id/pieces_list");
    }



    public function photos_list(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $request->validate([
                'photos' => 'required',
            ]);

            if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $image)
                {
                    
                    //$input = $request->all();
                    //$image = $request->file('photo'); //image file from frontend
            
                    //$student   = app('firebase.firestore')->database()->collection('Images')->document('defT5uT7SDu9K5RFtIdl');
                    $firebase_storage_path = 'Images/';
                    //$name     = $student->id();
                    $localfolder = public_path('firebase-temp-uploads') .'/';
                    $extension = $image->getClientOriginalExtension();
                    //$newName = time()*1000;
                    $newName = uniqid();
                    $file      = $newName . '.' . $extension;
                    if ($image->move($localfolder, $file)) {
                        $uploadedfile = fopen($localfolder.$file, 'r');
                        app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $file]);
                        //will remove from local laravel folder
                        unlink($localfolder . $file);
                        //Session::flash('message', 'Succesfully Uploaded');
                    }

                    $data = $request->all();
                    $data['link'] = $file;

                    Photo::create($data);

                    //sleep(1);

                }

                alert()->success('Successfull','The photos have been added to workorder');
                return redirect("/workorders/$id/photos_list");
            }

        }

        $workorder = Workorder::find($id);
        $photos_workorder = Photo::where('workorder_id', $workorder->id)->get();

        $images = array();
        foreach ($photos_workorder as $photo) {
            $expiresAt = new \DateTime('tomorrow');
            $imageReference = app('firebase.storage')->getBucket()->object("Images/".$photo->link);

            if ($imageReference->exists()) {
            $image = $imageReference->signedUrl($expiresAt);
            } else {
            $image = null;
            }
            array_push($images,$image);

        } 

        return view('workorders.photos_list', [
            'workorder' => $workorder,
            'photos_workorder' => $photos_workorder,
            'images' => $images
        ]);
    }

    public function removePhoto(Request $request)
    {
        $link = DB::table('photos')->where('id', $request->id)->value('link');
        Photo::where(['id' => $request->id, 'workorder_id' => $request->workorder_id])->delete();
        $imageDeleted = app('firebase.storage')->getBucket()->object("Images/".$link)->delete();
        alert()->success('Successfull','The photo has been removed of workorder');
        return redirect("/workorders/$request->workorder_id/photos_list");
    }


    public function signature(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            $folderPath = public_path('firebase-temp-uploads') .'/';
            $image_parts = explode(";base64,", $request->signed);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $unique = uniqid();
            $file = $folderPath . $unique . '.'.$image_type;
            file_put_contents($file, $image_base64);

            $image = $file; //image file from frontend
    
            $firebase_storage_path = 'Images/';
            $localfolder = public_path('firebase-temp-uploads') .'/';

            $file = $unique . '.'.$image_type;
            $uploadedfile = fopen($localfolder.$file, 'r');
            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $file]);
            //will remove from local laravel folder
            unlink($localfolder . $file);
            //Session::flash('message', 'Succesfully Uploaded');
            

            $workorder = Workorder::find($request->workorder_id);
            $workorder->update(['client_sign' => $file]);

            alert()->success('Successfull','The signature has been added to workorder');
            return redirect("/workorders");
        }
        
        $workorder = Workorder::find($id);

        $expiresAt = new \DateTime('tomorrow');
        $imageReference = app('firebase.storage')->getBucket()->object("Images/".$workorder->client_sign);

        $imgURL = "";
        if ($imageReference->exists()) {
            $image = $imageReference->signedUrl($expiresAt);
            $imgURL = $image;
        } else {
            $image = null;
        }

        return view('workorders.signature', [
            'workorder' => $workorder,
            'imgURL' => $imgURL
        ]);
    }

    public function generatePDF($id)
    {
        /*2 temp lines*/
        File::deleteDirectory(public_path('firebase-temp-uploads'));
        File::makeDirectory(public_path('firebase-temp-uploads'), 0777, true, true);

        File::deleteDirectory(public_path('firebase-temp-uploads'));
        File::makeDirectory(public_path('firebase-temp-uploads'), 0777, true, true);

        $workorder = Workorder::find($id);
        $client = Client::find($workorder->client_id);
        $user = User::find($workorder->user_id);
        $workorderState = WorkorderState::find($workorder->state_id);

        $pieces_workorder = WorkorderChangedPieces::where('workorder_id', $workorder->id)->get();
        $photos_workorder = Photo::where('workorder_id', $workorder->id)->get();

        //$images = array();
        foreach ($photos_workorder as $photo) {
            $expiresAt = new \DateTime('tomorrow');
            $imageReference = app('firebase.storage')->getBucket()->object("Images/".$photo->link);

            if ($imageReference->exists()) {
            $image = $imageReference->signedUrl($expiresAt);
            } else {
            $image = null;
            }
            //array_push($images,$image);

            $folderPath = public_path('firebase-temp-uploads') .'/';
            $file = $folderPath . $photo->link;
            file_put_contents($file, file_get_contents($image));
        } 

        $expiresAt = new \DateTime('tomorrow');
        $imageReference = app('firebase.storage')->getBucket()->object("Images/".$workorder->client_sign);

        if ($imageReference->exists()) {
            $image = $imageReference->signedUrl($expiresAt);
            $folderPath = public_path('firebase-temp-uploads') .'/';
            $file = $folderPath . $workorder->client_sign;
            file_put_contents($file, file_get_contents($image));
        } else {
            $image = null;
        }

        $data = [
            'workorder_id' => $workorder->id,
            'client_id' => $client->id,
            'client_first_name' => $client->first_name,
            'client_last_name' => $client->last_name,
            'user_id' => $user->id,
            'user_first_name' => $user->first_name,
            'user_last_name' => $user->last_name,
            'state_id' => $workorderState->id,
            'state_description' => $workorderState->description,
            'pieces_workorder' => $pieces_workorder,
            'photos_workorder' => $photos_workorder,
            'car_initial_state' => $workorder->car_initial_state,
            'car_initial_date' => $workorder->car_initial_date,
            'car_final_state' => $workorder->car_final_state,
            'car_final_date' => $workorder->car_final_date,
            'car_workorder_price' => $workorder->car_workorder_price,
            'client_sign' => $workorder->client_sign,
            //'images' => $images
        ];
          
        $pdf = PDF::loadView('workorders.my-pdf-file', $data);

        return $pdf->download('Workorder '.$workorder->id.'.pdf');
    }
    
    public function delete($id)
    {
        $workorder = Workorder::find($id);
        return view('workorders.delete', ['workorder' => $workorder]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $workorder = Workorder::find($id);
        $states = WorkorderState::all()->sortBy('id');
        $clients = Client::all()->sortBy('id');
        $users = User::all()->sortBy('id');
        return view('workorders.edit', ['workorder' => $workorder,
        'states' => $states,
        'clients' => $clients,
        'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'state_id' => 'required',
            'user_id' => 'required',
            'car_initial_state' => 'required',
            'car_initial_date' => 'required',
            'car_final_date' => 'after_or_equal:car_initial_date',
        ]);
        $workorder = Workorder::find($request->id);
        $workorder->update($request->all());
        alert()->success('Successfull','The workorder has been updated');
        return redirect('/workorders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workorder  $workorder
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Workorder::destroy($id);
            alert()->success('Successfull','The workorder has been deleted');
            return redirect('/workorders');
        } catch (\Throwable $th) {
            alert()->error('Error','Unable to delete this workorder because it is connected to photos or pieces');
            return redirect('/workorders');
        }
    }
}
