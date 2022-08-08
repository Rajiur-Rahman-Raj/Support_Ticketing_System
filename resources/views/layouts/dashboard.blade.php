@extends('layouts.app_backend')

@section('dashboard_active')
    active
@endsection

@section('content')

@if(Auth::user()->role_id == 1)
    <div class="container-fluid px-4">
        <div class="row row-cols-xxl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-3 my-2">
            <div class="col">
                <a href="{{ route('all_tickets.show') }}" style="text-decoration: none">

                    <div class="p-3 bg-white d-flex justify-content-around align-items-center rounded cards">
                            <div class="left-icon purple-clr">
                                <i class="bi bi-person-fill tickets-card-icons"></i>
                            </div>
                        <div>
                            <p class="fs-5">{{ __('Total Tickets') }}</p>
                            <h3 class="fs-2">{{ count($total_tickets) }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            @foreach ($status as $item)
                <div class="col">
                    <a href="{{ route('individual_ticket.show', $item->id) }}" style="text-decoration: none">
                        <div class="p-3 bg-white d-flex justify-content-around align-items-center rounded cards">
                                <div class="left-icon purple-clr">
                                    <i class="bi bi-person-fill tickets-card-icons"></i>
                                </div>
                            <div>
                                <p class="fs-5">{{ $item->name }} {{ __('Tickets') }}</p>
                                @php
                                    $ticket_data = App\Models\Ticket::where('status', $item->id)->get();
                                @endphp
                                <h3 class="fs-2">{{ count($ticket_data) }}</h3>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            {{-- <div class="col">
                <a href="{{ route('soft_deleted_tickets') }}" style="text-decoration: none">
                    <div
                        class="p-3 bg-white d-flex justify-content-around align-items-center rounded cards">
                            <div class="left-icon purple-clr">
                                <i class="bi bi-person-fill tickets-card-icons"></i>
                            </div>
                        <div>
                            <p class="fs-5">{{ __('Deleted Tickets') }}</p>
                            <h3 class="fs-2">{{ count($softDeletedTickets) }}</h3>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>
        <!--Other Chart Here -->
        <div class="chart mt-3">
            <div class="row">
                <div class="col-lg-7 mb-4">
                    <div class="chart__left bg-white p-3 rounded">
                        <div class=" chart__left__heading d-flex justify-content-between">
                            <div class="chart_left_heading_left">
                                <h4>{{ __('Ticket Analytics') }}</h4>
                            </div>
                            <div class="chart_left_heading_right">
                                <select class="form-select chart_left_heading_right--select border-0 ticket_analytics_admin" aria-label="Default select example">
                                    <option selected value="year">{{ __('Yearly') }}</option>
                                    <option value="month">{{ __('Month') }}</option>
                                </select>
                            </div>
                        </div>
                        <div id="chart_ticket"></div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="chart__right bg-white p-3">
                        <div class="chart__right__heading d-flex justify-content-between align-items-center">
                            <div class="chart_right_heading_left">
                                <h4>Current Issues</h4>
                            </div>
                            <div class="chart_right_heading_right">
                                <select class="form-select border-0 current_issues_chart" aria-label="Default select example">
                                    <option selected value="current_month">Current Month</option>
                                    <option value="previous_month">Previous Month</option>
                                </select>
                            </div>
                        </div>
                        <div id="chart2"></div>
                    </div>
                </div>

            </div>
        </div>

        <!--=====Ticket & Map=====-->

        <div class="cutomerTicket">
            <div class="row g-0">
                <div class="col-lg-7">
                    <div class="customerTicket__tickets bg-white mt-3 rounded p-3" style="margin-right: 8px;">
                        <div class="customerTicket__tickets_heading_dropdown d-flex justify-content-between">
                            <div class="heading">
                                <h3>{{ __('Customers With Most Ticket') }}</h3>
                            </div>
                            <div class="day">
                                <div class="dropdown">
                                    <div class="chart_right_heading_right">
                                        <select class="form-select border-0 today_tomorrow" aria-label="Default select example">
                                            <option selected value="today">Today</option>
                                            <option value="tomorrow">Previous Day</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="customerTicket_table table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Tickets</th>
                                        <th scope="col">Location</th>
                                        {{-- <th scope="col">Last Reply</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="today_tomorrow">
                                    @foreach ($today_best_ticket as $item)

                                        {{-- @if ($item->get_ticket->count() > 0) --}}
                                            <tr>
                                                {{-- <td>{{ $item->get_customer->name }}</td> --}}
                                                <td>{{ \App\Models\User::find($item->customer)->name }}</td>

                                                    <td>{{ $item->total }}</td>

                                                <td>
                                                    <div class="rounded-circle" style="width: 30%;">
                                                        @if (\App\Models\User::find($item->customer)->get_country_name->name == 'France')
                                                            <img src="{{ asset('uploads/country_flug/france.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Bangladesh')
                                                            <img src="{{ asset('uploads/country_flug/bangladesh.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'United Kingdom')
                                                            <img src="{{ asset('uploads/country_flug/uk.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'United States')
                                                            <img src="{{ asset('uploads/country_flug/us.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Afghanistan')
                                                            <img src="{{ asset('uploads/country_flug/afghanistan.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Angola')
                                                            <img src="{{ asset('uploads/country_flug/angola.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Albania')
                                                            <img src="{{ asset('uploads/country_flug/albania.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Antigua And Barbuda')
                                                            <img src="{{ asset('uploads/country_flug/antigua_and_barbuda.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Algeria')
                                                            <img src="{{ asset('uploads/country_flug/algeria.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Armenia')
                                                            <img src="{{ asset('uploads/country_flug/armenia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Aruba')
                                                            <img src="{{ asset('uploads/country_flug/aruba.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Argentina')
                                                            <img src="{{ asset('uploads/country_flug/argentina.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Australia')
                                                            <img src="{{ asset('uploads/country_flug/australia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Austria')
                                                            <img src="{{ asset('uploads/country_flug/austria.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Azerbaijan')
                                                            <img src="{{ asset('uploads/country_flug/azerbaijan.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Belgiam')
                                                            <img src="{{ asset('uploads/country_flug/belgium.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Bahamas')
                                                            <img src="{{ asset('uploads/country_flug/bahamas.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Bahrain')
                                                            <img src="{{ asset('uploads/country_flug/bahrain.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Barbados')
                                                            <img src="{{ asset('uploads/country_flug/barbados.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Belarus')
                                                            <img src="{{ asset('uploads/country_flug/belarus.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Beliz')
                                                            <img src="{{ asset('uploads/country_flug/beliz.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Benin')
                                                            <img src="{{ asset('uploads/country_flug/benin.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Bermuda')
                                                            <img src="{{ asset('uploads/country_flug/bermuda.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Bosnia And Herzegovina')
                                                            <img src="{{ asset('uploads/country_flug/bosnia_and_herzegovina.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Botswana')
                                                            <img src="{{ asset('uploads/country_flug/botswana.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Bolivia')
                                                            <img src="{{ asset('uploads/country_flug/bolivia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Bhutan')
                                                            <img src="{{ asset('uploads/country_flug/bhutan.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Brunai')
                                                            <img src="{{ asset('uploads/country_flug/brunai.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Bulgeria')
                                                            <img src="{{ asset('uploads/country_flug/bulgeria.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Burkina Faso')
                                                            <img src="{{ asset('uploads/country_flug/burkina_faso.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Burundi')
                                                            <img src="{{ asset('uploads/country_flug/burundi.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Brazil')
                                                            <img src="{{ asset('uploads/country_flug/brazil.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'China')
                                                            <img src="{{ asset('uploads/country_flug/china.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Canada')
                                                            <img src="{{ asset('uploads/country_flug/canada.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Chile')
                                                            <img src="{{ asset('uploads/country_flug/chile.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Colombia')
                                                            <img src="{{ asset('uploads/country_flug/colombia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Croatia')
                                                            <img src="{{ asset('uploads/country_flug/croatia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Cameroon')
                                                            <img src="{{ asset('uploads/country_flug/cameroon.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Cape Verde')
                                                            <img src="{{ asset('uploads/country_flug/cape_verde.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Central African Republic')
                                                            <img src="{{ asset('uploads/country_flug/central_african_republic.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Chad')
                                                            <img src="{{ asset('uploads/country_flug/chad.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Costa Rica')
                                                            <img src="{{ asset('uploads/country_flug/costa_rica.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Colombia')
                                                            <img src="{{ asset('uploads/country_flug/colombia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Combodia')
                                                            <img src="{{ asset('uploads/country_flug/combodia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Comoros')
                                                            <img src="{{ asset('uploads/country_flug/comoros.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Congo')
                                                            <img src="{{ asset('uploads/country_flug/congo.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Cuba')
                                                            <img src="{{ asset('uploads/country_flug/cuba.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Cyprus')
                                                            <img src="{{ asset('uploads/country_flug/cyprus.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Czech Republic')
                                                            <img src="{{ asset('uploads/country_flug/czech_republic.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Denmark')
                                                            <img src="{{ asset('uploads/country_flug/denmark.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Djibouti')
                                                            <img src="{{ asset('uploads/country_flug/djibuti.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Dominica')
                                                            <img src="{{ asset('uploads/country_flug/dominica.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Dominican Republic')
                                                            <img src="{{ asset('uploads/country_flug/dominican_republic.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Egypt')
                                                            <img src="{{ asset('uploads/country_flug/egypt.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Ecuador')
                                                            <img src="{{ asset('uploads/country_flug/equador.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Equatorial Guinea')
                                                            <img src="{{ asset('uploads/country_flug/equatorial_guinea.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Eritrea')
                                                            <img src="{{ asset('uploads/country_flug/eritrea.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Estonia')
                                                            <img src="{{ asset('uploads/country_flug/estonia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Ethiopia')
                                                            <img src="{{ asset('uploads/country_flug/ehiopia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'El Salvador')
                                                            <img src="{{ asset('uploads/country_flug/el_salvador.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Finland')
                                                            <img src="{{ asset('uploads/country_flug/finland.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Falkland Islands')
                                                            <img src="{{ asset('uploads/country_flug/falkland_islands.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Faroe Islands')
                                                            <img src="{{ asset('uploads/country_flug/faroe_islands.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Fiji')
                                                            <img src="{{ asset('uploads/country_flug/fiji.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'French Guiana')
                                                            <img src="{{ asset('uploads/country_flug/french_guiana.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Germany')
                                                            <img src="{{ asset('uploads/country_flug/germany.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Ghana')
                                                            <img src="{{ asset('uploads/country_flug/ghana.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Greece')
                                                            <img src="{{ asset('uploads/country_flug/greece.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Gabon')
                                                            <img src="{{ asset('uploads/country_flug/gabon.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Gambia')
                                                            <img src="{{ asset('uploads/country_flug/gambia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Georgia')
                                                            <img src="{{ asset('uploads/country_flug/georgia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Gibraltar')
                                                            <img src="{{ asset('uploads/country_flug/gibraltar.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Greenland')
                                                            <img src="{{ asset('uploads/country_flug/greenland.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Grenada')
                                                            <img src="{{ asset('uploads/country_flug/grenada.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Guatemala')
                                                            <img src="{{ asset('uploads/country_flug/guatemala.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Guinea')
                                                            <img src="{{ asset('uploads/country_flug/guinea.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Guinea Bissau')
                                                            <img src="{{ asset('uploads/country_flug/guinea_bissau.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Guyana Bissau')
                                                            <img src="{{ asset('uploads/country_flug/guyana.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Hong Kong')
                                                            <img src="{{ asset('uploads/country_flug/hong_kong.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Hungary')
                                                            <img src="{{ asset('uploads/country_flug/hungary.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Haiti')
                                                            <img src="{{ asset('uploads/country_flug/haiti.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Honduras')
                                                            <img src="{{ asset('uploads/country_flug/honduras.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Indonesia')
                                                            <img src="{{ asset('uploads/country_flug/indonesia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Iceland')
                                                            <img src="{{ asset('uploads/country_flug/iceland.png') }}" width="30" height="30" alt="1">

                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'India')
                                                            <img src="{{ asset('uploads/country_flug/india.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Iran')
                                                            <img src="{{ asset('uploads/country_flug/iran.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Iraq')
                                                            <img src="{{ asset('uploads/country_flug/iraq.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Italy')
                                                            <img src="{{ asset('uploads/country_flug/italy.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Israel')
                                                            <img src="{{ asset('uploads/country_flug/israel.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Ivory Coast')
                                                            <img src="{{ asset('uploads/country_flug/ivory_coast.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Ireland')
                                                            <img src="{{ asset('uploads/country_flug/ireland.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Japan')
                                                            <img src="{{ asset('uploads/country_flug/japan.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Jamaica')
                                                            <img src="{{ asset('uploads/country_flug/jamaica.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Jordan')
                                                            <img src="{{ asset('uploads/country_flug/jordan.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Jersey')
                                                            <img src="{{ asset('uploads/country_flug/jersey.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Kuwait')
                                                            <img src="{{ asset('uploads/country_flug/kuwait.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Kenya')
                                                            <img src="{{ asset('uploads/country_flug/kenya.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Kazakhstan')
                                                            <img src="{{ asset('uploads/country_flug/kazakhstan.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Kiribat')
                                                            <img src="{{ asset('uploads/country_flug/kiribat.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Kosovo')
                                                            <img src="{{ asset('uploads/country_flug/kosovo.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Kyrgyzstan')
                                                            <img src="{{ asset('uploads/country_flug/kyrgyzstan.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Malaysia')
                                                                <img src="{{ asset('uploads/country_flug/malaysia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Laos')
                                                            <img src="{{ asset('uploads/country_flug/laos.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Latvia')
                                                            <img src="{{ asset('uploads/country_flug/latvia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Lebanon')
                                                            <img src="{{ asset('uploads/country_flug/lebanon.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Lesotho')
                                                            <img src="{{ asset('uploads/country_flug/lesotho.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Liberia')
                                                            <img src="{{ asset('uploads/country_flug/liberia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Lithunia')
                                                            <img src="{{ asset('uploads/country_flug/lithunia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Luxembourge')
                                                            <img src="{{ asset('uploads/country_flug/luxembourge.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Libya')
                                                            <img src="{{ asset('uploads/country_flug/libya.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Mexico')
                                                            <img src="{{ asset('uploads/country_flug/mexico.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Malaysia')
                                                            <img src="{{ asset('uploads/country_flug/malaysia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Monaco')
                                                            <img src="{{ asset('uploads/country_flug/monaco.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Norway')
                                                            <img src="{{ asset('uploads/country_flug/norway.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'North Korea')
                                                            <img src="{{ asset('uploads/country_flug/north_korea.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'New Zealands')
                                                            <img src="{{ asset('uploads/country_flug/new_zealands.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Netherlands')
                                                            <img src="{{ asset('uploads/country_flug/netherlands.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Portugal')
                                                            <img src="{{ asset('uploads/country_flug/portugal.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Pakistan')
                                                            <img src="{{ asset('uploads/country_flug/pakistan.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Qatar')
                                                            <img src="{{ asset('uploads/country_flug/qatar.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Russia')
                                                            <img src="{{ asset('uploads/country_flug/russia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Saudi Arabia')
                                                            <img src="{{ asset('uploads/country_flug/saudi_arabia.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Singapore')
                                                            <img src="{{ asset('uploads/country_flug/singapore.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'South Africa')
                                                            <img src="{{ asset('uploads/country_flug/south_africa.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'South Korea')
                                                            <img src="{{ asset('uploads/country_flug/south_korea.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Spain')
                                                            <img src="{{ asset('uploads/country_flug/spain.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Sweden')
                                                            <img src="{{ asset('uploads/country_flug/sweden.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Switzerland')
                                                            <img src="{{ asset('uploads/country_flug/switzerland.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Thailand')
                                                            <img src="{{ asset('uploads/country_flug/thailand.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Turkey')
                                                            <img src="{{ asset('uploads/country_flug/turkey.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Ukraine')
                                                            <img src="{{ asset('uploads/country_flug/ukraine.png') }}" width="30" height="30" alt="1">
                                                        @elseif(\App\Models\User::find($item->customer)->get_country_name->name == 'Uruguay')
                                                            <img src="{{ asset('uploads/country_flug/uruguay.png') }}" width="30" height="30" alt="1">
                                                        @endif
                                                    </div>
                                                </td>

                                            </tr>
                                        {{-- @endif --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="map bg-white p-3 mt-3" style="margin-left: 16px">
                        <div class="map_heading">
                            <div class="map__map_heading text-center">
                                <p class="p-0 m-0 ">Bangladesh</p>
                                <h5 class="mt-3 map_value">{{ $country_wise_customer }}</h5>
                            </div>
                            <div class="customer_count d-flex justify-content-between text-center map_heading">
                                <div class=" customer_count_total cmn_style">
                                    <p class="mb-2">Active Tickets</p>
                                    <h3 style="color: #6C7BFF;" class="map_value">{{ $country_wise_ticket_active }}</h3>
                                </div>
                                <div class="divider"></div>
                                <div class="customer_count_active cmn_style">
                                    <p class="mb-2">Solved Tickets</p>
                                    <h3 style="color: #34DDAA;">{{ $country_wise_ticket_solved }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="map_show">
                            <div id="vmap" style="height: 276px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- support ticket --}}
        <div class="support_ticket">
            <div class="col-lg-12">
                <div class="support mt-5">

                    <div class="current_tickets_heading d-flex justify-content-between mt-5 mb-0">
                        <div class="current_tickets_heading__left mb-4">
                            <h3>{{ __('All Support Tickets') }}</h3>
                        <p>{{ __('List of ticket open by customers') }}</p>

                        </div>
                        <div class="current_tickets_heading__right d-flex align-items-center">
                            <div class="input-group mb-3 me-2">
                                <button class="btn bg-white" id="button-addon1">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                                <input type="text" id="search_tickets" class="form-control border-0" placeholder="Search Tickets.."
                                    aria-label="Example text with button addon"  aria-describedby="button-addon1" name="Search Keyword">
                            </div>

                        </div>
                    </div>
                    <div class="row align-items-end mt-2 mb-5">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="from__date">From</label>
                                <input type="date" name="from_date" id="from__date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="to__date">To</label>
                                <input type="date" name="to_date" id="to__date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <div class="form-group">
                                <button class="btn btn-primary" id="filter__date">filter</button>
                                <button class="btn btn-danger d-none" id="clear__filter__date">Clear filter</button>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-group">
                                <label for="to__date">Agents</label>
                                <select name="agent_id[]" id="agent_id" class="form-control" multiple="">
                                    @foreach ($all_agents as $agent)
                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <div class="form-group">
                                <button class="btn btn-primary" id="filter__agents">filter</button>
                                <button class="btn btn-danger d-none" id="clear__filter__agents">Clear filter</button>
                            </div>
                        </div>
                        {{-- <form> --}}

                        {{-- </form> --}}
                    </div>

                    <div class="user_list user-page table-responsive table-overflow-none">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Assignee') }}</th>
                                    <th>{{ __('Department') }}</th>
                                    <th>{{ __('Subjects') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Priority') }}</th>
                                    <th>{{ __('Created Date') }}</th>
                                    <th>{{ __('Message') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="render_tickets">
                                @include('includes.tickets.index')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <!-- Load More -->
                <div class="load_more_button">
                    <div class="mt-5 mb-5 text-center">
                    <a id="load-more" data-count="5" class="load__more__btn load_more bg-accent shadow-accent-volume hover:bg-accent-dark inline-block rounded-full text-center font-semibold text-white transition-all">
                        Load More
                    </a>
                    </div>
                </div>
            </div>
        </div>



        <!--=====Ticket & Map=====-->

        <div class="cutomerTicket">
            <div class="row g-0">
            </div>
        </div>
        <!--=====Support Tickets=====-->

        <div class="support_tickets_modal">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <!-- <h5 class="modal-title" id="exampleModalLabel">New message</h5> -->
                            <div class="modal_btn">
                                <button class="modal_btn__ind">{{ __('Assign individually') }}</button>
                                <button class="modal_btn_team bg-transparent border-0">{{ __('Assign To Team') }}</button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label"><b>{{ __('Select') }}</b></label>
                                    <input type="text" class="form-control" id="recipient-name">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn modal_close_btn"
                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                            <button type="button" class="btn modal_save_btn">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@elseif(Auth::user()->role_id == 2)
    @include('admin.agent.dashboard')
@else
    @include('admin.customer.dashboard')
@endif


@endsection

@section('js')

    <script>
        var options = {
            series: [{
            name: 'Total tickets',
            data: @json($customer_total_ticket)
            }, {
            name: 'Opended ticket',
            data: @json($customer_opened_ticket)
            }, {
            name: 'Pending Tickets',
            data: @json($customer_pending_ticket)
            }, {
            name: 'Solved ticket',
            data: @json($customer_solved_ticket)
            }],
            chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false,
            }
            },
            plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
            },
            dataLabels: {
            enabled: true
            },
            stroke: {
            show: true,
            width:1,
            colors: ['transparent']
            },
            xaxis: {
            categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            fill: {
            opacity: 0.8
            },
            tooltip: {
            y: {
                formatter: function (val) {
                return val
                }
            }
            }
        };

        var chart = new ApexCharts(document.querySelector("#customer_chart_ticket"), options);
        chart.render();
    </script>

    <script>
        var options = {
            series: [{
            name: 'Total tickets',
            data: @json($agent_total_ticket)
            }, {
            name: 'Opended ticket',
            data: @json($agent_opened_ticket)
            }, {
            name: 'Pending Tickets',
            data: @json($agent_pending_ticket)
            }, {
            name: 'Solved ticket',
            data: @json($agent_solved_ticket)
            }],
            chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false,
            }
            },
            plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
            },
            dataLabels: {
            enabled: true
            },
            stroke: {
            show: true,
            width:1,
            colors: ['transparent']
            },
            xaxis: {
            categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            fill: {
            opacity: 0.8
            },
            tooltip: {
            y: {
                formatter: function (val) {
                return val
                }
            }
            }
        };

        var chart = new ApexCharts(document.querySelector("#agent_chart_ticket"), options);
        chart.render();
    </script>


    @foreach ($tickets as $item)
        <script>

            $(document).ready(function() {
                $('#get_agent_dropdown{{ $item->id }}').select2({theme: "classic"});
            });

        </script>
    @endforeach

    <script>
        $(document).ready(function() {
            $('#agent_id').select2({theme: "classic"});

        });
    </script>

    <script>
        $(document).ready(function() {

            $('.dept_dropdown').change(function() {

                var dept_id = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('get.agents') }}",
                    data: {
                        dept_id: dept_id
                    },
                    success: function(data) {
                        $('.get_agent_dropdown').html(data.data)
                    }
                })
            });
        });
    </script>


    {{-- filter by date js --}}
    <script>
        $(document).ready(function() {
                $('#filter__date').on('click',function(){
                    let from_date = $('#from__date').val();
                    let to_date = $('#to__date').val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('date.wise.tickets') }}",
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                        },
                        success: function(response) {
                            console.log(response);
                            if ((response.count)*1 <  1) {
                                $('#render_tickets').html('<tr ><td colspan="1000" class="text-danger text-center py-3">No Ticket Found</td></tr>');
                            } else {
                                $('#render_tickets').html(response.data);
                            }

                            if ((1*response.count) < 5) {
                                $('.load_more_button').hide();
                            }else{
                                $('.load_more_button').show();

                            }

                            $("#clear__filter__date").removeClass("d-none");


                        }
                    })

                });
                // clear filter
                $("#clear__filter__date").on("click", function(){
                    $(this).addClass("d-none");
                    $("#from__date").val("");
                    $("#to__date").val("");

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('date.clear.wise.tickets') }}",

                        success: function(response) {
                            $('#render_tickets').html(response.data);

                            if ((1*response.count) < 5) {
                                $('.load_more_button').hide();
                            }else{
                                $('.load_more_button').show();

                            }
                        }
                    })
                });
            });
    </script>

    {{-- filter by agents js --}}
    <script>
        $(document).ready(function() {
                $('#filter__agents').on('click',function(){
                    let agents_id = $('#agent_id').val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('agent.wise.tickets') }}",
                        data: {
                            agents_id: agents_id,
                        },
                        success: function(response) {
                            console.log(response);
                            if ((response.count)*1 <  1) {
                                $('#render_tickets').html('<tr ><td colspan="1000" class="text-danger text-center py-3">No Ticket Found</td></tr>');
                            } else {
                                $('#render_tickets').html(response.data);
                            }

                            if ((1*response.count) < 5) {
                                $('.load_more_button').hide();
                            }else{
                                $('.load_more_button').show();

                            }

                            $("#clear__filter__agents").removeClass("d-none");


                        }
                    })
                });
                // clear filter
                $("#clear__filter__agents").on("click", function(){
                    $(this).addClass("d-none");
                    $("#agent_id").val("");

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('agent.clear.wise.tickets') }}",

                        success: function(response) {
                            $('#render_tickets').html(response.data);

                            if ((1*response.count) < 5) {
                                $('.load_more_button').hide();
                            }else{
                                $('.load_more_button').show();

                            }
                        }
                    })
                });
            });
    </script>


    {{-- search wise tickets --}}
    <script>
        $(document).ready(function() {
                $('#search_tickets').on('keyup',function(){
                    let search_value = $(this).val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('search.wise.tickets') }}",
                        data: {
                            search_value: search_value,
                        },
                        success: function(response) {
                            console.log(response);
                            if ((response.count)*1 <  1) {
                                $('#render_tickets').html('<tr ><td colspan="1000" class="text-danger text-center py-3">No Ticket Found</td></tr>');
                            } else {
                                $('#render_tickets').html(response.data);
                            }

                            if ((1*response.count) < 5) {
                                $('.load_more_button').hide();
                            }else{
                                $('.load_more_button').show();

                            }

                        }
                    })

                });
            });
    </script>

    {{-- Load More Btn js --}}
    <script>
        $(document).ready(function () {
            $('.load_more').click(function () {

                let count = $(this).attr('data-count');
                let search_value = $('#search_tickets').val();

                let from_date = $('#from__date').val();
                let to_date = $('#to__date').val();

                let agents_id = $('#agent_id').val();


                let load_more = $(this);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('tickets.load-more') }}",
                    type: "post",
                    data:{
                        count:count,
                        search_value:search_value,
                        from_date:from_date,
                        to_date:to_date,
                        agents_id:agents_id,
                    },
                    success: function(data)
                    {
                        console.log(data);
                        $(load_more).attr('data-count', data.count);

                        if ((1*data.ticket_count) < 5) {
                            $('.load_more_button').hide();
                        }else{
                            $('.load_more_button').show();
                        }

                        $('#render_tickets').append(data.data);

                        $("html, body").animate({
                                scrollTop: $('html, body').get(0).scrollHeight
                            }, 10);

                    }
                })

            });
        });
    </script>



    <script>
        $(document).ready(function(){
            $('.ticket_analytics_admin').on('change', function(){
                let data = $(this).val();


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('ticket.analytics.admin') }}",
                    type: "post",
                    data:{
                        data:data,
                    },
                    success: function(data)
                    {
                        console.log(data);
                        $('#chart_ticket').html(data.data);

                    }
                })

            });
        });
    </script>

    {{-- Current Issues Chart --}}

    <script>
        $(document).ready(function(){
            $('.current_issues_chart').on('change', function(){
                let month = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('current.issues.chart') }}",
                    type: "post",
                    data:{
                        month:month,
                    },
                    success: function(data)
                    {
                        console.log(data);
                        $('#chart2').html(data.data);

                    }
                })

            });
        });
    </script>


    <script>
        var options = {
            series: [{
            name: 'Opended Ticket',
            data: @json($opened_ticket)
            },{
            name: 'Solved Ticket',
            data: @json($solved_ticket)
            }],
            chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false,
            }
            },
            plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '100%',
                endingShape: 'rounded'
            },
            },
            dataLabels: {
            enabled: true
            },
            stroke: {
            show: true,
            width:1,
            colors: ['transparent']
            },
            xaxis: {
            categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            fill: {
            opacity: 0.8
            },
            tooltip: {
            y: {
                formatter: function (val) {
                return val
                }
            }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_ticket"), options);
        chart.render();
    </script>

    <script>
        // Area Chart
    var lineChartOptions = {
    series: [{
        name: 'Open Tickets',
        data: @json($open_ticket_datas)

        // [1646162003000, 38.34],
        // [1646248403000, 38.10],
        // [1646334803000, 38.51],
        // [1646432003000, 38.40],
    },{
        name: 'Solved Tickets',
        data: @json($close_ticket_datas)
    }],
    chart: {
        id: 'area-datetime',
        type: 'area',
        height: 350,
        zoom: {
        autoScaleYaxis: true
        },
        toolbar: {
        show: false
        }
    },
    annotations: {
        yaxis: [{
        y: 30,
        borderColor: '#999',
        label: {
            show: true,
            text: 'Support',
            style: {
            color: "#fff",
            background: '#00E396'
            }
        }
        }],
        xaxis: [{
        x: new Date('14 Nov 2012').getTime(),
        borderColor: '#999',
        yAxisIndex: 0,
        label: {
            show: true,
            // text: 'Rally',
            style: {
            color: "#fff",
            background: '#775DD0'
            }
        }
        }]
    },
    dataLabels: {
        enabled: false
    },
    markers: {
        size: 0,
        style: 'hollow',
    },
    xaxis: {
        type: 'datetime',
        min: new Date('{{ $view_month }}').getTime(),
        tickAmount: 6,
    },
    tooltip: {
        x: {
        format: 'dd MMM yyyy'
        }
    },
    fill: {
        type: 'gradient',
        gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.7,
        opacityTo: 0.9,
        stops: [0, 100]
        }
    },
    };

    var chart2 = new ApexCharts(document.querySelector("#chart2"), lineChartOptions);
    chart2.render();
    </script>

    <script>
        $(document).ready(function(){
            $('.today_tomorrow').on('change', function(){
                let search_value = $(this).val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('today.tomorrow.ticket') }}",
                    type: "post",
                    data:{
                        search_value:search_value,
                    },
                    success: function(data)
                    {
                        console.log(data);
                        $('#today_tomorrow').html(data.data);

                    }
                })

            });
        });
    </script>


@endsection
