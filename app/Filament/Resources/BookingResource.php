<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Court;
use App\Models\ProfilUser;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Carbon\Carbon; // Import Carbon

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Manajemen Lapangan';
    protected static ?string $navigationLabel = 'Booking Lapangan';

    protected static ?string $pluralModelLabel = 'Booking Lapangan';
    protected static ?string $modelLabel = 'Booking Lapangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('profils_user_id')
                            ->label('Pengguna')
                            ->relationship('profilsUser', 'full_name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('court_id')
                            ->label('Lapangan')
                            ->options(function () {
                                return Court::with('venue')->get()->mapWithKeys(function ($court) {
                                    return [$court->id => $court->name . ' (' . ($court->venue->name ?? 'N/A') . ')'];
                                });
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(onBlur: true) // Tambahkan live untuk menghitung ulang harga jika lapangan berubah
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                // Panggil ulang logika perhitungan harga jika lapangan berubah
                                $startTime = \Carbon\Carbon::parse($get('start_time'));
                                $endTime = \Carbon\Carbon::parse($get('end_time'));
                                if ($startTime && $endTime && $endTime->greaterThan($startTime)) {
                                    $duration = $endTime->diffInHours($startTime);
                                    $set('duration_hours', $duration);
                                    $courtId = $state; // State adalah court_id yang baru
                                    if ($courtId) {
                                        $court = Court::find($courtId);
                                        if ($court) {
                                            $set('total_price', $duration * $court->base_price_per_hour);
                                        }
                                    }
                                } else {
                                    $set('duration_hours', 0);
                                    $set('total_price', 0);
                                }
                            }),

                        Forms\Components\DatePicker::make('booking_date')
                            ->label('Tanggal Booking')
                            ->required()
                            ->live(onBlur: true), // Tambahkan live
                            // Anda mungkin ingin menambahkan validasi untuk slot waktu yang tersedia di sini

                        Forms\Components\TimePicker::make('start_time')
                            ->label('Waktu Mulai')
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $startTime = \Carbon\Carbon::parse($state);
                                $endTime = \Carbon\Carbon::parse($get('end_time'));
                                if ($startTime && $endTime && $endTime->greaterThan($startTime)) {
                                    $duration = $endTime->diffInHours($startTime);
                                    $set('duration_hours', $duration);
                                    $courtId = $get('court_id');
                                    if ($courtId) {
                                        $court = Court::find($courtId);
                                        if ($court) {
                                            $set('total_price', $duration * $court->base_price_per_hour);
                                        }
                                    }
                                } else {
                                    $set('duration_hours', 0);
                                    $set('total_price', 0);
                                }
                            }),

                        Forms\Components\TimePicker::make('end_time')
                            ->label('Waktu Selesai')
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $startTime = \Carbon\Carbon::parse($get('start_time'));
                                $endTime = \Carbon\Carbon::parse($state);
                                if ($startTime && $endTime && $endTime->greaterThan($startTime)) {
                                    $duration = $endTime->diffInHours($startTime);
                                    $set('duration_hours', $duration);
                                    $courtId = $get('court_id');
                                    if ($courtId) {
                                        $court = Court::find($courtId);
                                        if ($court) {
                                            $set('total_price', $duration * $court->base_price_per_hour);
                                        }
                                    }
                                } else {
                                    $set('duration_hours', 0);
                                    $set('total_price', 0);
                                }
                            }),

                        Forms\Components\TextInput::make('duration_hours')
                            ->label('Durasi (Jam)')
                            ->required()
                            ->numeric()
                            ->suffix('jam')
                            ->readOnly(), // Ini seharusnya dihitung, bukan diinput manual

                        Forms\Components\TextInput::make('total_price')
                            ->label('Total Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->thousandsSeparator(',')
                                ->decimalCharacters('.') // Jika Anda menggunakan titik sebagai desimal
                                ->padFractionalZeros()
                                ->normalizeZeros()
                                ->mapToDecimalSeparator([','])
                                ->stripCharacters(['.', ','])
                            )
                            ->readOnly(),

                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Pemesan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('customer_phone')
                            ->label('Telepon Pemesan')
                            ->tel()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('status')
                            ->label('Status Booking')
                            ->options([
                                'pending' => 'Menunggu Pembayaran',
                                'waiting_payment' => 'Menunggu Pembayaran (Lanjut)',
                                'awaiting_confirmation' => 'Menunggu Konfirmasi',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                'failed' => 'Gagal',
                            ])
                            ->required()
                            ->default('pending')
                            ->columnSpanFull()
                            ->live() // Tambahkan live untuk memicu perubahan di Fieldset Payment
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                // Otomatis atur status pembayaran jika booking menjadi 'completed' atau 'cancelled'
                                if ($state === 'completed') {
                                    $set('payment.status', 'paid');
                                    $set('payment.paid_at', now());
                                } elseif ($state === 'cancelled' || $state === 'failed') {
                                    $set('payment.status', 'failed');
                                }
                            }),

                        Fieldset::make('Informasi Pembayaran (Opsional)')
                            ->schema([
                                Select::make('payment.status')
                                    ->label('Status Pembayaran')
                                    ->options([
                                        'pending' => 'Menunggu Pembayaran',
                                        'paid' => 'Sudah Dibayar',
                                        'failed' => 'Gagal',
                                        'expired' => 'Kedaluwarsa',
                                    ])
                                    ->default('pending')
                                    ->nullable()
                                    ->live()
                                    ->visibleOn('edit') // Pastikan ini hanya terlihat saat edit
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        if ($state === 'paid') {
                                            $set('payment.paid_at', now());
                                        } else {
                                            $set('payment.paid_at', null);
                                        }
                                    }),

                                TextInput::make('payment.payment_method')
                                    ->label('Metode Pembayaran')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->visibleOn('edit'),

                                TextInput::make('payment.transaction_id')
                                    ->label('ID Transaksi')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->visibleOn('edit'),

                                TextInput::make('payment.account_name')
                                    ->label('Nama Akun Pembayar')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->visible(fn(Forms\Get $get) => in_array($get('payment.payment_method'), ['Manual Transfer', 'Bank Transfer', 'Transfer Bank']))
                                    ->visibleOn('edit'),

                                TextInput::make('payment.account_number')
                                    ->label('Nomor Akun Pembayar')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->visible(fn(Forms\Get $get) => in_array($get('payment.payment_method'), ['Manual Transfer', 'Bank Transfer', 'Transfer Bank']))
                                    ->visibleOn('edit'),

                                TextInput::make('payment.payment_code')
                                    ->label('Kode Pembayaran / Virtual Account')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->visible(fn(Forms\Get $get) => in_array($get('payment.payment_method'), ['Virtual Account', 'QRIS', 'VA']))
                                    ->visibleOn('edit'),

                                DatePicker::make('payment.expires_at')
                                    ->label('Kadaluarsa Pembayaran')
                                    ->nullable()
                                    ->visibleOn('edit'),

                                DatePicker::make('payment.paid_at')
                                    ->label('Waktu Dibayar')
                                    ->nullable()
                                    ->visible(fn(Forms\Get $get) => $get('payment.status') === 'paid')
                                    ->visibleOn('edit'),
                            ])->columns(2)
                            // Anda mungkin ingin menambahkan 'mutateRelationDataBeforeSave' pada Fieldset jika payment selalu ada
                            ->relationship('payment')
                            ->columns(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('profilsUser.full_name')
                    ->label('Pengguna')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('court.name')
                    ->label('Lapangan')
                    ->description(fn (Booking $record): string => $record->court->venue->name ?? 'N/A')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('booking_date')
                    ->label('Tanggal Booking')
                    ->date('d F Y')
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('Mulai')
                    ->time('H:i'),
                TextColumn::make('end_time')
                    ->label('Selesai')
                    ->time('H:i'),
                TextColumn::make('duration_hours')
                    ->label('Durasi')
                    ->suffix(' jam')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->label('Nama Pemesan')
                    ->searchable(),
                TextColumn::make('customer_phone')
                    ->label('Telepon Pemesan')
                    ->searchable(),
                BadgeColumn::make('status')
                    ->label('Status Booking')
                    ->colors([
                        'warning' => 'pending',
                        'warning' => 'waiting_payment',
                        'info' => 'awaiting_confirmation',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                        'danger' => 'failed',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('payment.status')
                    ->label('Status Pembayaran')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                        'secondary' => 'expired',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state)))
                    ->tooltip(fn (Booking $record): ?string => $record->payment ? "Metode: {$record->payment->payment_method}\nID Transaksi: {$record->payment->transaction_id}\nKadaluarsa: {$record->payment->expires_at?->format('d M Y H:i')}" : null)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d F Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d F Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status Booking')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'waiting_payment' => 'Menunggu Pembayaran (Lanjut)',
                        'awaiting_confirmation' => 'Menunggu Konfirmasi',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        'failed' => 'Gagal',
                    ]),
                SelectFilter::make('payment_status') // Ubah dari 'payment.status' ke 'payment_status' untuk filter
                    ->label('Filter Status Pembayaran')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'paid' => 'Sudah Dibayar',
                        'failed' => 'Gagal',
                        'expired' => 'Kedaluwarsa',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value']) && $data['value'] !== null) {
                            $query->whereHas('payment', function (Builder $paymentQuery) use ($data) {
                                $paymentQuery->where('status', $data['value']);
                            });
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Batalkan')
                    ->label('Batalkan Booking')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Booking Ini?')
                    ->modalDescription('Apakah Anda yakin ingin membatalkan booking ini? Status booking akan diubah menjadi "Dibatalkan" dan status pembayaran menjadi "Gagal".')
                    ->modalSubmitActionLabel('Ya, Batalkan')
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'cancelled']);
                        if ($record->payment) {
                            $record->payment->update(['status' => 'failed', 'paid_at' => null]); // Set paid_at to null if failed
                        } else {
                            // Jika tidak ada record pembayaran, buat satu dengan status gagal
                            Payment::create([
                                'booking_id' => $record->id,
                                'profils_user_id' => $record->profils_user_id,
                                'amount' => $record->total_price,
                                'payment_method' => 'N/A', // Atau metode default jika dibatalkan tanpa pembayaran
                                'status' => 'failed',
                                'expires_at' => null,
                                'paid_at' => null,
                            ]);
                        }
                        \Filament\Notifications\Notification::make()
                            ->title('Booking Dibatalkan')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Booking $record): bool => !in_array($record->status, ['completed', 'cancelled', 'failed'])),

                Tables\Actions\Action::make('Selesaikan')
                    ->label('Selesaikan Booking')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->modalHeading('Selesaikan Booking Ini?')
                    ->modalDescription('Apakah Anda yakin booking ini sudah selesai? Status booking akan diubah menjadi "Selesai". Pastikan pembayaran sudah lunas.')
                    ->modalSubmitActionLabel('Ya, Selesaikan')
                    ->action(function (Booking $record) {
                        $record->update(['status' => 'completed']);
                        // Pastikan pembayaran ada dan update statusnya menjadi 'paid'
                        if ($record->payment) {
                            $record->payment->update(['status' => 'paid', 'paid_at' => now()]);
                        } else {
                            // Jika belum ada record pembayaran, buat satu dengan status 'paid'
                            Payment::create([
                                'booking_id' => $record->id,
                                'profils_user_id' => $record->profils_user_id,
                                'amount' => $record->total_price,
                                'payment_method' => 'Manual Confirmation', // Atau metode default
                                'status' => 'paid',
                                'expires_at' => null,
                                'paid_at' => now(),
                            ]);
                        }
                        \Filament\Notifications\Notification::make()
                            ->title('Booking Selesai')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Booking $record): bool => $record->status === 'awaiting_confirmation'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['court.venue', 'profilsUser', 'payment']);
    }
}