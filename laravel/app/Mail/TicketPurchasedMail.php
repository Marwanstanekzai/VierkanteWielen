<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketPurchasedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket->relationLoaded('bezoeker') && $ticket->relationLoaded('evenement') && $ticket->relationLoaded('prijs')
            ? $ticket
            : $ticket->load(['bezoeker', 'evenement', 'prijs']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bevestiging van je Sneakerness Rotterdam-ticketaankoop',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_purchased',
            with: [
                'ticket' => $this->ticket,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
