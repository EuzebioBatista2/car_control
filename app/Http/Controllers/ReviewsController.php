<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Reviews;
use App\Models\Vehicles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Lang;


class ReviewsController extends Controller
{
    //
    public function index()
    {
        $auth_user = auth()->user()->id;
        $reviews = Reviews::select('reviews.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->orderBy('name', 'asc')->paginate(5);
        $columns = [];

        if ($reviews->count() > 0) {
            $columns = array_keys($reviews->first()->getAttributes());

            foreach ($columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $columns[$key] = ucfirst($column);
                }
            }
        }

        return view('reviews', ['reviews' => $reviews, 'columns' => $columns, 'search' => '']);
    }

    public function index_owner_review($id)
    {
        $auth_user = auth()->user()->id;

        if (!(intval($id) == $id)) {
            return redirect()->route('reviews');
        }

        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();

        if ($vehicle && $vehicle['id'] != $id) {
            return view('access_denied');
        }


        $reviews = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->where('reviews.vehicle_id', "$id")
            ->orderBy('date_review', 'asc')->paginate(5);
        $columns = [];

        if ($reviews->count() > 0) {
            $columns = array_keys($reviews->first()->getAttributes());

            foreach ($columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $columns[$key] = ucfirst($column);
                }
            }
        }

        $current_date = date('Y-m-d\TH:i');

        return view('reviews_owner', ['reviews' => $reviews, 'vehicle' => $vehicle, 'columns' => $columns, 'old_date' => '', 'date' => $current_date]);
    }

    public function validator(array $data)
    {
        Alert::error('Erro', 'Um ou mais campos apresentam erro(s). Por favor, corrija os campos destacados.')->persistent(true, true);

        return Validator::make($data, [
            'problems' => ['required', 'string', 'min:3', 'max:255'],
        ], [
            /* Problems */
            'problems.required' => 'O campo problema(s) encontrado(s) deve ser preenchido.',
            'problems.string' => 'Problema(s) deve ser do tipo TEXTO',
            'peoblemas.min' => 'Problema(s) abaixo do limite permitido, min:3.',
            'peoblemas.max' => 'Problema(s) acima do limite permitido, max:255.',
        ]);
    }

    public function create(Request $request, int $id)
    {
        $this->validator($request->all())->validate();

        Reviews::create([
            'vehicle_id' => $request->input('vehicle_id'),
            'problems' => $request->input('problems'),
            'date_review' => date('Y-m-d H:i:s'),
            'completed' => '0',
        ]);

        Alert::success('Sucesso', 'Cadastro de revisão realizado com sucesso.')->persistent(true, true);

        return redirect()->route('owner_review', ['id' => $id]);
    }

    public function edit($id_vehicle, $id_review)
    {

        $auth_user = auth()->user()->id;

        if (!(intval($id_vehicle) == $id_vehicle)) {
            return redirect()->route('owner_review', ['id' => $id_vehicle]);
        }

        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id_vehicle")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();

        if ($vehicle && $vehicle['id'] != $id_vehicle) {
            return view('access_denied');
        }

        $review = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->where('reviews.vehicle_id', "$id_vehicle")
            ->where('reviews.id', "$id_review")
            ->first()
            ->getAttributes();

        $review['date_review'] = substr($review['date_review'], 0, 10) . 'T' . substr($review['date_review'], 11, 5);

        if ($vehicle) {
            return view('edit_review', ['review' => $review]);
        }

        return view('access_denied');
    }

    public function update(Request $request, $id_vehicle, $id_review)
    {
        $auth_user = auth()->user()->id;

        if (!(intval($id_vehicle) == $id_vehicle)) {
            return redirect()->route('owner_review', ['id' => $id_vehicle]);
        }

        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id_vehicle")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();

        if ($vehicle && $vehicle['id'] != $id_vehicle) {
            return view('access_denied');
        }

        $review = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->where('reviews.vehicle_id', "$id_vehicle")
            ->where('reviews.id', "$id_review")
            ->first();

        /* Fomat data */
        $review['date_review'] = substr($review['date_review'], 0, 10) . 'T' . substr($review['date_review'], 11, 5);
        $format_completed = $request->input('completed') ? '1' : '0';

        if ($review) {
            if (
                $review['date_review'] === $request->input('date_review') &&
                $review['completed'] === $format_completed &&
                $review['problems'] == $request->input('problems')
            ) {
                Alert::warning('Aviso', 'Prencha os campos com novos dados para realizar uma atualização!')->persistent(true, true);
                return redirect()->route('owner_review', ['id' => $id_vehicle]);
            }

            $review->update([
                'date_review' => $request->input('date_review'),
                'completed' => $format_completed,
                'problems' => $request->input('problems'),
            ]);
        } else {
            return view('access_denied');
        }

        Alert::success('Sucesso', 'Cadastro de revisão atualizado com sucesso!')->persistent(true, true);

        return redirect()->route('owner_review', ['id' => $id_vehicle]);
    }

    public function destroy($id_vehicle, $id_review)
    {
        $auth_user = auth()->user()->id;

        if (!(intval($id_vehicle) == $id_vehicle)) {
            return redirect()->route('owner_review', ['id' => $id_vehicle]);
        }

        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id_vehicle")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();

        if ($vehicle && $vehicle['id'] != $id_vehicle) {
            return view('access_denied');
        }

        $review = Reviews::where('id', $id_review)->first();
        if ($review) {
            Alert::success('Sucesso', 'Cadastro de revisão excluído com sucesso!')->persistent(true, true);
            $review->delete();
        } else {
            Alert::error('Erro', 'Infelizmente não foi possivel excluir o registro selecionado.')->persistent(true, true);
        }

        return redirect()->route('owner_review', ['id' => $id_vehicle]);
    }

    public function search(Request $request)
    {
        $auth_user = auth()->user()->id;

        $query = $request->input('brand');

        $reviews = Reviews::select('reviews.id', 'customers.name', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color', 'reviews.date_review', 'reviews.problems', 'reviews.completed', 'vehicles.id as vehicle_id')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', "vehicles.id")
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('customers.admin_id', "$auth_user")
            ->where('vehicles.brand', "ilike", '%' . $query . '%')
            ->orderBy('name', 'asc')->paginate(5);

        $columns = [];

        if ($reviews->count() > 0) {
            $columns = array_keys($reviews->first()->getAttributes());

            foreach ($columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $columns[$key] = ucfirst($column);
                }
            }
        }

        return view('reviews', ['reviews' => $reviews, 'columns' => $columns, 'search' => $query]);
    }

    public function search_owner(Request $request, $id)
    {
        $initial_date = $request->input('initial_date');
        $final_date = $request->input('final_date');

        $auth_user = auth()->user()->id;

        if (!(intval($id) == $id)) {
            return redirect()->route('reviews');
        }

        $vehicle = Vehicles::select('vehicles.id', 'customers.name', 'customers.lastname', 'customers.email', 'customers.phone', 'vehicles.brand', 'vehicles.model', 'vehicles.year', 'vehicles.color')
            ->leftJoin('customers', 'vehicles.customer_id', '=', "customers.id")
            ->leftJoin('admins', 'customers.admin_id', '=', "admins.id")
            ->where('vehicles.id', "$id")
            ->where('admins.id', "$auth_user")
            ->first()
            ->getAttributes();

        if ($vehicle && $vehicle['id'] != $id) {
            return view('access_denied');
        }


        $reviews = Reviews::select('reviews.id', 'reviews.date_review', 'reviews.problems', 'reviews.completed')
            ->leftJoin('vehicles', 'reviews.vehicle_id', '=', 'vehicles.id')
            ->leftJoin('customers', 'vehicles.customer_id', '=', 'customers.id')
            ->leftJoin('admins', 'customers.admin_id', '=', 'admins.id')
            ->where('customers.admin_id', $auth_user)
            ->where('reviews.vehicle_id', $id);

        if ($initial_date != '') {
            $reviews->whereBetween('reviews.date_review', [$initial_date, $final_date]);
        } else {
            $reviews->where('reviews.date_review', '<=', $final_date);
        }

        $reviews = $reviews->orderBy('date_review', 'desc')
            ->paginate(5);

        $columns = [];

        if ($reviews->count() > 0) {
            $columns = array_keys($reviews->first()->getAttributes());

            foreach ($columns as $key => $column) {
                $translated_column = Lang::get("messages.$column");
                if ($translated_column !== "messages.$column") {
                    // Se a tradução existe, substitue a coluna pelo seu equivalente traduzido
                    $columns[$key] = ucfirst($translated_column);
                } else {
                    // Se a tradução não existe, capitaliza a primeira letra e substitua a coluna
                    $columns[$key] = ucfirst($column);
                }
            }
        }

        $current_date = date('Y-m-d\TH:i');

        return view('reviews_owner', ['reviews' => $reviews, 'vehicle' => $vehicle, 'columns' => $columns, 'old_date' => $initial_date, 'date' => $current_date]);
    }
}
