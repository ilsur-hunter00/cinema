<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Screening;
use App\Services\client\TicketService;
use DateTime;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketController extends Controller
{
    private TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function getTicket(Request $request)
    {
        $tickets = $this->ticketService->getTicket($request->all());

        return view('client.ticket', $tickets);
    }

    public function getPayment(Request $request)
    {
        $payments = $this->ticketService->getPayment($request->all());

        return view('client.payment', $payments);
    }
}
