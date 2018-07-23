<?php

namespace App\Http\Controllers;

use App\Ticket;

use Illuminate\Http\Request;
use App\Http\Requests\TicketFormRequest;
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index')->with('tickets',$tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketFormRequest $request)
    {
        $slug = uniqid();
        $ticket = new Ticket(array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'slug' => $slug
        ));

        $ticket->save();

        $data = array(
            'ticket'=>$slug,
        );

        Mail::send('emails.ticket', $data, function ($message) {
            $message->from('thanhthuk59@gmail.com', 'Learning Laravel');
            $message->to('phan.thanh.thu@framgia.com')->subject('There is a new ticket!');
        });

        return redirect('/contact')->with('status', 'Your ticket has been created! Its unique id is: '.$slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($slug)
     {
         $ticket = Ticket::whereSlug($slug)->firstOrFail();
         $comments = $ticket->comments()->get();
         return view('tickets.show', compact('ticket', 'comments'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $ticket = Ticket::whereSlug($slug)->first();
        return view('tickets.edit')->with('ticket',$ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TicketFormRequest $request, $slug)
    {
        $ticket = Ticket::whereSlug($slug)->first();
        $ticket->title = $request->get('title');
        $ticket->content = $request->get('content');
        if($request->get('status') != null) {
            $ticket->status = 0;
        } else {
            $ticket->status = 1;
        }
        $ticket->save();
        return redirect(action('TicketsController@edit', $ticket->slug))->with('status', 'The ticket '.$slug.' has been updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $ticket = Ticket::whereSlug($slug)->first();
        $ticket->delete();
        return redirect('/tickets')->with('status','The ticket '.$slug.' has been deleted!');
    }
}
