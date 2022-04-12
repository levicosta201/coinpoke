@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                                        </div>
                                    </div>
                                </div>
                                <!-- End -->
                            @endforeach
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
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
                    satoshiPrice = data.data.value.price.toFixed(7);

                    $.each(pokeExperienceRows, function(index, value) {
                        console.log(satoshiPrice);

                        let rowId = $(value).data('id');
                        let pokemonExperience = $(value).text();
                        let rowCoinValue = $('.usdCoinValue-' + rowId)
                        rowCoinValue.text(pokemonExperience * parseFloat(satoshiPrice));
                        rowCoinValue.show();
                    });
                }
            });
        }
    });
</script>
@endsection
