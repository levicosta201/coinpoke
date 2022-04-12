@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endsection
@section('content')
<div class="container">
    <section id="minimal-statistics">
        <div class="row">
            <div class="col-12 mt-3 mb-1">
                <h4 class="text-uppercase">Estatísticas</h4>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="align-self-center">
                                    <i class="icon-pencil primary font-large-2 float-left"></i>
                                </div>
                                <div class="media-body text-right">
                                    <h3>$ {{ round($totalWallet, 7) }}</h3>
                                    <span>Dólares</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(\Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ \Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            {{ \Session::forget('success') }}
            @if(\Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ \Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            {{ \Session::forget('error') }}
            <div class="card">
                <div class="card-header">{{ __('Suas Compras') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <div class="row">
                        @foreach($pokemons as $pokemon)
                            @php
                                $pokemon = $pokemon->pokemon
                            @endphp
                            <!-- Gallery item -->
                                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                                    <div class="bg-white rounded shadow-sm"><img src="{{ $pokemon->image }}" alt="" class="img-fluid card-img-top">
                                        <div class="p-4 rowItem">
                                            <h5> <a href="#" class="text-dark">{{ ucfirst($pokemon->name) }}</a></h5>
                                            {{--                                <p class="small text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>--}}
                                            <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-2">
                                                <p class="small mb-0"><i class="fa-solid fa-star-sharp"></i>Experience: <span class="font-weight-bold pokeExperience" data-id="{{ $pokemon->id }}">{{ $pokemon->base_experience }}</span></p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between rounded-pill bg-light px-3 py-2 mt-2">
                                                <p class="small mb-0"><i class="fa-solid fa-star-sharp"></i>USD: $ <span class="font-weight-bold usdCoinValue-{{ $pokemon->id }} hidden"></span></p>
                                            </div>
                                            <a href="{{ route('sell', $pokemon->id) }}" class="btn btn-primary mt-4 text-center justify-center">Vender</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End -->
                            @endforeach
                        </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">{{ __('Log de Transações') }}</div>

                <div class="card-body">
                    <div class="row">
                        <!-- Gallery item -->
                        <div class="col-xl-12 col-lg-12 col-md-12 mb-12">
                            <table class="table" id="transactionLogTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Pokemon</th>
                                        <th scope="col">Experience</th>
                                        <th scope="col">Cotação do Dia</th>
                                        <th scope="col">Valor da Compra/Venda</th>
                                        <th scope="col">Operação</th>
                                        <th scope="col">Data da Compra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ ucfirst($transaction->pokemon->name) }}</td>
                                        <td>{{ $transaction->pokemon->base_experience }}</td>
                                        <td>{{ round($transaction->coin_price, 7) }}</td>
                                        <td>{{ round($transaction->coin_price * $transaction->pokemon->base_experience, 7) }}</td>
                                        <td>{{ $transaction->operation == 'buy' ? 'Compra' : 'Venda' }}</td>
                                        <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.1.1.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {

            $("#transactionLogTable").DataTable();

            getPokemonsPrice();

            setInterval(function () {
                getPokemonsPrice();
            }, 5000);

            function getPokemonsPrice() {
                var satoshiPrice = 0;
                let pokeExperienceRows = $('.pokeExperience');

                $.ajax({
                    url: '{{ route('api.coin.convert') }}',
                    cache: false,
                    success: function(data) {
                        satoshiPrice = data.data.value.price;

                        $.each(pokeExperienceRows, function(index, value) {
                            console.log(satoshiPrice);

                            let rowId = $(value).data('id');
                            let pokemonExperience = $(value).text();
                            let rowCoinValue = $('.usdCoinValue-' + rowId)
                            rowCoinValue.text((pokemonExperience * parseFloat(satoshiPrice)).toFixed(7));
                            rowCoinValue.show();
                        });
                    }
                });
            }
        });
    </script>
@endsection
