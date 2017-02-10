<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mailers\AppMailer;
use App\Ticket;
use App\Category;

use Auth;

class TicketsController extends Controller
{
    /*This way, all the methods in TicketsController will only be accessible by authenticated users.*/



    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userTickets()
    {
    $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
    $categories = Category::all();

    return view('tickets.user_tickets', compact('tickets', 'categories'));
    }
        /*The TicketsController now has a create() function which will get all the categories created and pass them along to a view file. Before we move further, lets create the routes that will handle opening a new ticket.*/
    public function create()
	{
    	$categories = Category::all();

    	return view('tickets.create', compact('categories'));
	}

	public function store(Request $request, AppMailer $mailer)
	{
    $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'ticket_id' => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => "Open",
        ]);

        $ticket->save();

        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect()->back()->with("status", "A ticket with ID: #$ticket->ticket_id has been opened.");
	}

    public function show($ticket_id) {
        $user=Auth::user();
        $userTickets = $user->tickets()->where('user_id', $user->id);
        $isAdminUser = $user->is_admin == 1;

        if ($userTickets->count() > 0 || $isAdminUser) {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $comments = $ticket->comments;
        $category = $ticket->category;

        return view('tickets.show', compact('ticket', 'category', 'comments'));
        } else {
        return redirect('home');
        }
    }

    public function index()
    {
    $tickets = Ticket::paginate(10);
    $categories = Category::all();

    return view('tickets.index', compact('tickets', 'categories'));
    }

    public function close($ticket_id, AppMailer $mailer)
    {
    $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

    $ticket->status = 'Closed';

    $ticket->save();

    $ticketOwner = $ticket->user;

    $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

    return redirect()->back()->with("status", "Ticket fechado.");
    }

}
