<?php

namespace App\Http\Controllers;

use App\Models\PivotServiceRequest;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function requestsByYear () {
        try {
            $yearRequests = ServiceRequest::
            whereYear("created_at",Carbon::now()->year)
            ->get()
            ->groupBy(function ($q) {
                return Carbon::parse($q->created_at)->format('m');
            });

            foreach ($yearRequests as $index => $month) {
                $data[] = ["month"=>$index,"value"=>$month->count()];
            }

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

    public function incomeByYear () {
        try {
            $yearRequests = ServiceRequest::
            whereYear("created_at",Carbon::now()->year)
            ->get()
            ->groupBy(function ($q) {
                return Carbon::parse($q->created_at)->format('m');
            });

            foreach ($yearRequests as $index => $month) {
                $data[] = ["month"=>$index,"value"=>$month->sum('total')];
            }

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

    public function mostRequestedServices () {
        try {
            $mostServices = PivotServiceRequest::
            whereMonth("created_at",Carbon::now()->month)
            ->with('services')
            ->get()
            ->groupBy('service_id');


            $data = collect();

            foreach ($mostServices as  $service) {
                $selectedService = $service[0]->services;
                if (count($selectedService)) {
                    $data->push(["service"=>$selectedService[0]->name,"value"=>$service->sum('quantity')]);
                }
            }

            $data = $data->sortByDesc('value')->take(3);


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
