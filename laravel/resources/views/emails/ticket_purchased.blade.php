<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bevestiging van je Sneakerness Rotterdam-ticketaankoop</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1f2937; line-height: 1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f4f7; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid #e5e7eb;">
                    <!-- HEADER -->
                    <tr>
                        <td style="background-color: #0b0c10; padding: 28px 32px; text-align: left; border-bottom: 3px solid #ff3b30;">
                            <div style="font-size: 24px; font-weight: 900; letter-spacing: 2px; color: #ffffff; text-transform: uppercase;">
                                SNEAKERNESS
                            </div>
                            <div style="font-size: 11px; font-weight: 800; letter-spacing: 3px; color: #ff3b30; text-transform: uppercase; margin-top: 2px;">
                                ROTTERDAM
                            </div>
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding: 32px;">
                            <div style="display: inline-block; background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; padding: 6px 12px; border-radius: 9999px; margin-bottom: 16px;">
                                Aankoop Succesvol
                            </div>

                            <h1 style="font-size: 22px; font-weight: 800; color: #111827; margin: 0 0 12px 0;">
                                Beste {{ $ticket->bezoeker->Naam ?? 'klant' }},
                            </h1>

                            <p style="font-size: 15px; color: #4b5563; margin: 0 0 24px 0;">
                                Je aankoop voor Sneakerness Rotterdam is succesvol afgerond! Hieronder vind je alle gegevens van je bestelling:
                            </p>

                            <!-- DETAILS TABLE -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; margin-bottom: 24px; background-color: #f9fafb; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;">
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #6b7280; font-size: 13px; width: 40%;">Ticketnummer / Bestelnummer:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 800; color: #111827; font-size: 14px;">SNK-2026-T{{ $ticket->Id }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #6b7280; font-size: 13px;">Naam evenement:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 700; color: #111827; font-size: 14px;">{{ $ticket->evenement->Naam ?? 'Sneakerness Rotterdam 2026' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #6b7280; font-size: 13px;">Datum:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; color: #111827; font-size: 14px;">{{ \Carbon\Carbon::parse($ticket->Datum)->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #6b7280; font-size: 13px;">Gekozen tijdslot:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; color: #111827; font-size: 14px;">{{ $ticket->prijs->Tijdslot ?? 'Regulier tijdslot' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #6b7280; font-size: 13px;">Aantal gekochte tickets:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 700; color: #111827; font-size: 14px;">{{ $ticket->AantalTickets }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #6b7280; font-size: 13px;">Prijs per ticket:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; color: #111827; font-size: 14px;">€ {{ number_format($ticket->prijs->Tarief ?? 0, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 600; color: #6b7280; font-size: 13px;">Totaalbedrag:</td>
                                    <td style="padding: 12px 16px; border-bottom: 1px solid #e5e7eb; font-weight: 800; color: #ff3b30; font-size: 16px;">€ {{ number_format(($ticket->prijs->Tarief ?? 0) * $ticket->AantalTickets, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px 16px; font-weight: 600; color: #6b7280; font-size: 13px;">E-mailadres bestelling:</td>
                                    <td style="padding: 12px 16px; color: #111827; font-size: 14px;">{{ $ticket->bezoeker->{'E-mailadres'} ?? '-' }}</td>
                                </tr>
                            </table>

                            <!-- LOCATION & INSTRUCTIONS -->
                            <div style="background-color: #f3f4f6; border-radius: 8px; padding: 16px; margin-bottom: 24px; font-size: 13px; color: #4b5563;">
                                <strong style="color: #111827; display: block; margin-bottom: 4px;">📍 Locatie & Toegang:</strong>
                                Van Nellefabriek Rotterdam (Van Nelleweg 1, 3044 BC Rotterdam)<br>
                                Neem deze e-mail digitaal of geprint mee samen met je ticketnummer bij binnenkomst.
                            </div>

                            <!-- CLOSING GREETING -->
                            <p style="font-size: 15px; font-weight: 600; color: #111827; margin: 0 0 24px 0;">
                                Bedankt voor je aankoop en tot ziens bij Sneakerness Rotterdam!
                            </p>

                            <p style="font-size: 13px; color: #6b7280; margin: 0;">
                                Met vriendelijke groet,<br>
                                <strong style="color: #111827;">Het Sneakerness Rotterdam Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 32px; text-align: center; border-top: 1px solid #e5e7eb; font-size: 12px; color: #9ca3af;">
                            &copy; 2026 Sneakerness Rotterdam. Deze e-mail is automatisch verzonden ter bevestiging van je ticketaankoop.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
