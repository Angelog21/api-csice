<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{

    public function cardsUpper () {
        try {
            $todayRequests = ServiceRequest::whereDate('created_at', Carbon::today())->get();

            $data = [
                "totalCount"=>$todayRequests->count(),
                "aprobatedCount"=>$todayRequests->where("status","Aprobado")->count(),
                "completedCount"=>$todayRequests->where("status","Completado")->count(),
                "incomeToday"=>$todayRequests->sum("total")
            ];

            return response([
                "success"=>true,
                "message" => "Se ha obtenido la data correctamente.",
                "data"=>$data
            ],200);
        } catch (\Exception $e) {
            return response([
                    "success"=>false,
                    "message" => "Ha ocurrido un error con el servidor.",
                    "data"=>$e->getMessage()
                ],500);
        }
    }

    public function requestsByStatus () {
        try {
            $todayRequests = ServiceRequest::whereMonth('created_at', Carbon::now()->month)->get();

            $data = [
                "totalCount"=>$todayRequests->count(),
                "aprobatedCount"=>$todayRequests->where("status","Aprobado")->count(),
                "createdCount"=>$todayRequests->where("status","Creado")->count(),
                "rejectedCount"=>$todayRequests->where("status","Rechazado")->count(),
                "completedCount"=>$todayRequests->where("status","Completado")->count(),
            ];

            return response([
                "success"=>true,
                "message" => "Se ha obtenido la data correctamente.",
                "data"=>$data
            ],200);

        } catch (\Exception $e) {
            return response([
                    "success"=>false,
                    "message" => "Ha ocurrido un error con el servidor.",
                    "data"=>$e->getMessage()
                ],500);
        }
    }
}
