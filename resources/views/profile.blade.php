<x-layout pageTitle="Profile">
    <!-- Content area -->
    <div class="content">

        <!-- Dashboard content -->
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="sidebar-section-body text-center" style="padding: 20px;">
                                <div class="card-img-actions d-inline-block mb-3">
                                    <img class="img-fluid rounded-circle" src="{{ auth()->user()->avatar }}" width="150" height="150" alt="">
                                    <div class="card-img-actions-overlay card-img rounded-circle">
                                        <input type="file" name="avatar" class="form-control" id="avatar" accept="image/*">
                                        <a href="#" class="btn btn-outline-white btn-icon rounded-pill" id="avatar-upload">
                                            <i class="ph-pencil"></i>
                                        </a>
                                    </div>
                                </div>

                                <h6 class="mb-0">{{ $user->name }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Update Profile</h5>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ url('/profile') }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <label class="form-label">Name:</label>
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Currency:</label>
                                        <div class="form-group">
                                            <select id="currency" data-placeholder="Select a Currency..." name="currency" class="form-control select" required>
                                                <option>--Select currency--</option>
                                                <option value="AFN" {{ old('currency', $user->currency) == 'AFN' ? "selected" : "" }}>AFN - Afghan Afghani</option>
                                                <option value="ALL" {{ old('currency', $user->currency) == 'ALL' ? "selected" : "" }}>ALL - Albanian Lek</option>
                                                <option value="DZD" {{ old('currency', $user->currency) == 'DZD' ? "selected" : "" }}>DZD - Algerian Dinar</option>
                                                <option value="AOA" {{ old('currency', $user->currency) == 'AOA' ? "selected" : "" }}>AOA - Angolan Kwanza</option>
                                                <option value="ARS" {{ old('currency', $user->currency) == 'ARS' ? "selected" : "" }}>ARS - Argentine Peso</option>
                                                <option value="AMD" {{ old('currency', $user->currency) == 'AMD' ? "selected" : "" }}>AMD - Armenian Dram</option>
                                                <option value="AWG" {{ old('currency', $user->currency) == 'AWG' ? "selected" : "" }}>AWG - Aruban Florin</option>
                                                <option value="AUD" {{ old('currency', $user->currency) == 'AUD' ? "selected" : "" }}>AUD - Australian Dollar</option>
                                                <option value="AZN" {{ old('currency', $user->currency) == 'AZN' ? "selected" : "" }}>AZN - Azerbaijani Manat</option>
                                                <option value="BSD" {{ old('currency', $user->currency) == 'BSD' ? "selected" : "" }}>BSD - Bahamian Dollar</option>
                                                <option value="BHD" {{ old('currency', $user->currency) == 'BHD' ? "selected" : "" }}>BHD - Bahraini Dinar</option>
                                                <option value="BDT" {{ old('currency', $user->currency) == 'BDT' ? "selected" : "" }}>BDT - Bangladeshi Taka</option>
                                                <option value="BBD" {{ old('currency', $user->currency) == 'BBD' ? "selected" : "" }}>BBD - Barbadian Dollar</option>
                                                <option value="BYR" {{ old('currency', $user->currency) == 'BYR' ? "selected" : "" }}>BYR - Belarusian Ruble</option>
                                                <option value="BEF" {{ old('currency', $user->currency) == 'BEF' ? "selected" : "" }}>BEF - Belgian Franc</option>
                                                <option value="BZD" {{ old('currency', $user->currency) == 'BZD' ? "selected" : "" }}>BZD - Belize Dollar</option>
                                                <option value="BMD" {{ old('currency', $user->currency) == 'BMD' ? "selected" : "" }}>BMD - Bermudan Dollar</option>
                                                <option value="BTN" {{ old('currency', $user->currency) == 'BTN' ? "selected" : "" }}>BTN - Bhutanese Ngultrum</option>
                                                <option value="BTC" {{ old('currency', $user->currency) == 'BTC' ? "selected" : "" }}>BTC - Bitcoin</option>
                                                <option value="BOB" {{ old('currency', $user->currency) == 'BOB' ? "selected" : "" }}>BOB - Bolivian Boliviano</option>
                                                <option value="BAM" {{ old('currency', $user->currency) == 'BAM' ? "selected" : "" }}>BAM - Bosnia-Herzegovina Convertible Mark</option>
                                                <option value="BWP" {{ old('currency', $user->currency) == 'BWP' ? "selected" : "" }}>BWP - Botswanan Pula</option>
                                                <option value="BRL" {{ old('currency', $user->currency) == 'BRL' ? "selected" : "" }}>BRL - Brazilian Real</option>
                                                <option value="GBP" {{ old('currency', $user->currency) == 'GBP' ? "selected" : "" }}>GBP - British Pound Sterling</option>
                                                <option value="BND" {{ old('currency', $user->currency) == 'BND' ? "selected" : "" }}>BND - Brunei Dollar</option>
                                                <option value="BGN" {{ old('currency', $user->currency) == 'BGN' ? "selected" : "" }}>BGN - Bulgarian Lev</option>
                                                <option value="BIF" {{ old('currency', $user->currency) == 'BIF' ? "selected" : "" }}>BIF - Burundian Franc</option>
                                                <option value="KHR" {{ old('currency', $user->currency) == 'KHR' ? "selected" : "" }}>KHR - Cambodian Riel</option>
                                                <option value="CAD" {{ old('currency', $user->currency) == 'CAD' ? "selected" : "" }}>CAD - Canadian Dollar</option>
                                                <option value="CVE" {{ old('currency', $user->currency) == 'CVE' ? "selected" : "" }}>CVE - Cape Verdean Escudo</option>
                                                <option value="KYD" {{ old('currency', $user->currency) == 'KYD' ? "selected" : "" }}>KYD - Cayman Islands Dollar</option>
                                                <option value="XOF" {{ old('currency', $user->currency) == 'XOF' ? "selected" : "" }}>XOF - CFA Franc BCEAO</option>
                                                <option value="XAF" {{ old('currency', $user->currency) == 'XAF' ? "selected" : "" }}>XAF - CFA Franc BEAC</option>
                                                <option value="XPF" {{ old('currency', $user->currency) == 'XPF' ? "selected" : "" }}>XPF - CFP Franc</option>
                                                <option value="CLP" {{ old('currency', $user->currency) == 'CLP' ? "selected" : "" }}>CLP - Chilean Peso</option>
                                                <option value="CNY" {{ old('currency', $user->currency) == 'CNY' ? "selected" : "" }}>CNY - Chinese Yuan</option>
                                                <option value="COP" {{ old('currency', $user->currency) == 'COP' ? "selected" : "" }}>COP - Colombian Peso</option>
                                                <option value="KMF" {{ old('currency', $user->currency) == 'KMF' ? "selected" : "" }}>KMF - Comorian Franc</option>
                                                <option value="CDF" {{ old('currency', $user->currency) == 'CDF' ? "selected" : "" }}>CDF - Congolese Franc</option>
                                                <option value="CRC" {{ old('currency', $user->currency) == 'CRC' ? "selected" : "" }}>CRC - Costa Rican ColÃ³n</option>
                                                <option value="HRK" {{ old('currency', $user->currency) == 'HRK' ? "selected" : "" }}>HRK - Croatian Kuna</option>
                                                <option value="CUC" {{ old('currency', $user->currency) == 'CUC' ? "selected" : "" }}>CUC - Cuban Convertible Peso</option>
                                                <option value="CZK" {{ old('currency', $user->currency) == 'CZK' ? "selected" : "" }}>CZK - Czech Republic Koruna</option>
                                                <option value="DKK" {{ old('currency', $user->currency) == 'DKK' ? "selected" : "" }}>DKK - Danish Krone</option>
                                                <option value="DJF" {{ old('currency', $user->currency) == 'DJF' ? "selected" : "" }}>DJF - Djiboutian Franc</option>
                                                <option value="DOP" {{ old('currency', $user->currency) == 'DOP' ? "selected" : "" }}>DOP - Dominican Peso</option>
                                                <option value="XCD" {{ old('currency', $user->currency) == 'XCD' ? "selected" : "" }}>XCD - East Caribbean Dollar</option>
                                                <option value="EGP" {{ old('currency', $user->currency) == 'EGP' ? "selected" : "" }}>EGP - Egyptian Pound</option>
                                                <option value="ERN" {{ old('currency', $user->currency) == 'ERN' ? "selected" : "" }}>ERN - Eritrean Nakfa</option>
                                                <option value="EEK" {{ old('currency', $user->currency) == 'EEK' ? "selected" : "" }}>EEK - Estonian Kroon</option>
                                                <option value="ETB" {{ old('currency', $user->currency) == 'ETB' ? "selected" : "" }}>ETB - Ethiopian Birr</option>
                                                <option value="EUR" {{ old('currency', $user->currency) == 'EUR' ? "selected" : "" }}>EUR - Euro</option>
                                                <option value="FKP" {{ old('currency', $user->currency) == 'FKP' ? "selected" : "" }}>FKP - Falkland Islands Pound</option>
                                                <option value="FJD" {{ old('currency', $user->currency) == 'FJD' ? "selected" : "" }}>FJD - Fijian Dollar</option>
                                                <option value="GMD" {{ old('currency', $user->currency) == 'GMD' ? "selected" : "" }}>GMD - Gambian Dalasi</option>
                                                <option value="GEL" {{ old('currency', $user->currency) == 'GEL' ? "selected" : "" }}>GEL - Georgian Lari</option>
                                                <option value="DEM" {{ old('currency', $user->currency) == 'DEM' ? "selected" : "" }}>DEM - German Mark</option>
                                                <option value="GHS" {{ old('currency', $user->currency) == 'GHS' ? "selected" : "" }}>GHS - Ghanaian Cedi</option>
                                                <option value="GIP" {{ old('currency', $user->currency) == 'GIP' ? "selected" : "" }}>GIP - Gibraltar Pound</option>
                                                <option value="GRD" {{ old('currency', $user->currency) == 'GRD' ? "selected" : "" }}>GRD - Greek Drachma</option>
                                                <option value="GTQ" {{ old('currency', $user->currency) == 'GTQ' ? "selected" : "" }}>GTQ - Guatemalan Quetzal</option>
                                                <option value="GNF" {{ old('currency', $user->currency) == 'GNF' ? "selected" : "" }}>GNF - Guinean Franc</option>
                                                <option value="GYD" {{ old('currency', $user->currency) == 'GYD' ? "selected" : "" }}>GYD - Guyanaese Dollar</option>
                                                <option value="HTG" {{ old('currency', $user->currency) == 'HTG' ? "selected" : "" }}>HTG - Haitian Gourde</option>
                                                <option value="HNL" {{ old('currency', $user->currency) == 'HNL' ? "selected" : "" }}>HNL - Honduran Lempira</option>
                                                <option value="HKD" {{ old('currency', $user->currency) == 'HKD' ? "selected" : "" }}>HKD - Hong Kong Dollar</option>
                                                <option value="HUF" {{ old('currency', $user->currency) == 'HUF' ? "selected" : "" }}>HUF - Hungarian Forint</option>
                                                <option value="ISK" {{ old('currency', $user->currency) == 'ISK' ? "selected" : "" }}>ISK - Icelandic KrÃ³na</option>
                                                <option value="INR" {{ old('currency', $user->currency) == 'INR' ? "selected" : "" }}>INR - Indian Rupee</option>
                                                <option value="IDR" {{ old('currency', $user->currency) == 'IDR' ? "selected" : "" }}>IDR - Indonesian Rupiah</option>
                                                <option value="IRR" {{ old('currency', $user->currency) == 'IRR' ? "selected" : "" }}>IRR - Iranian Rial</option>
                                                <option value="IQD" {{ old('currency', $user->currency) == 'IQD' ? "selected" : "" }}>IQD - Iraqi Dinar</option>
                                                <option value="ILS" {{ old('currency', $user->currency) == 'ILS' ? "selected" : "" }}>ILS - Israeli New Sheqel</option>
                                                <option value="ITL" {{ old('currency', $user->currency) == 'ITL' ? "selected" : "" }}>ITL - Italian Lira</option>
                                                <option value="JMD" {{ old('currency', $user->currency) == 'JMD' ? "selected" : "" }}>JMD - Jamaican Dollar</option>
                                                <option value="JPY" {{ old('currency', $user->currency) == 'JPY' ? "selected" : "" }}>JPY - Japanese Yen</option>
                                                <option value="JOD" {{ old('currency', $user->currency) == 'JOD' ? "selected" : "" }}>JOD - Jordanian Dinar</option>
                                                <option value="KZT" {{ old('currency', $user->currency) == 'KZT' ? "selected" : "" }}>KZT - Kazakhstani Tenge</option>
                                                <option value="KES" {{ old('currency', $user->currency) == 'KES' ? "selected" : "" }}>KES - Kenyan Shilling</option>
                                                <option value="KWD" {{ old('currency', $user->currency) == 'KWD' ? "selected" : "" }}>KWD - Kuwaiti Dinar</option>
                                                <option value="KGS" {{ old('currency', $user->currency) == 'KGS' ? "selected" : "" }}>KGS - Kyrgystani Som</option>
                                                <option value="LAK" {{ old('currency', $user->currency) == 'LAK' ? "selected" : "" }}>LAK - Laotian Kip</option>
                                                <option value="LVL" {{ old('currency', $user->currency) == 'LVL' ? "selected" : "" }}>LVL - Latvian Lats</option>
                                                <option value="LBP" {{ old('currency', $user->currency) == 'LBP' ? "selected" : "" }}>LBP - Lebanese Pound</option>
                                                <option value="LSL" {{ old('currency', $user->currency) == 'LSL' ? "selected" : "" }}>LSL - Lesotho Loti</option>
                                                <option value="LRD" {{ old('currency', $user->currency) == 'LRD' ? "selected" : "" }}>LRD - Liberian Dollar</option>
                                                <option value="LYD" {{ old('currency', $user->currency) == 'LYD' ? "selected" : "" }}>LYD - Libyan Dinar</option>
                                                <option value="LTL" {{ old('currency', $user->currency) == 'LTL' ? "selected" : "" }}>LTL - Lithuanian Litas</option>
                                                <option value="MOP" {{ old('currency', $user->currency) == 'MOP' ? "selected" : "" }}>MOP - Macanese Pataca</option>
                                                <option value="MKD" {{ old('currency', $user->currency) == 'MKD' ? "selected" : "" }}>MKD - Macedonian Denar</option>
                                                <option value="MGA" {{ old('currency', $user->currency) == 'MGA' ? "selected" : "" }}>MGA - Malagasy Ariary</option>
                                                <option value="MWK" {{ old('currency', $user->currency) == 'MWK' ? "selected" : "" }}>MWK - Malawian Kwacha</option>
                                                <option value="MYR" {{ old('currency', $user->currency) == 'MYR' ? "selected" : "" }}>MYR - Malaysian Ringgit</option>
                                                <option value="MVR" {{ old('currency', $user->currency) == 'MVR' ? "selected" : "" }}>MVR - Maldivian Rufiyaa</option>
                                                <option value="MRO" {{ old('currency', $user->currency) == 'MRO' ? "selected" : "" }}>MRO - Mauritanian Ouguiya</option>
                                                <option value="MUR" {{ old('currency', $user->currency) == 'MUR' ? "selected" : "" }}>MUR - Mauritian Rupee</option>
                                                <option value="MXN" {{ old('currency', $user->currency) == 'MXN' ? "selected" : "" }}>MXN - Mexican Peso</option>
                                                <option value="MDL" {{ old('currency', $user->currency) == 'MDL' ? "selected" : "" }}>MDL - Moldovan Leu</option>
                                                <option value="MNT" {{ old('currency', $user->currency) == 'MNT' ? "selected" : "" }}>MNT - Mongolian Tugrik</option>
                                                <option value="MAD" {{ old('currency', $user->currency) == 'MAD' ? "selected" : "" }}>MAD - Moroccan Dirham</option>
                                                <option value="MZM" {{ old('currency', $user->currency) == 'MGM' ? "selected" : "" }}>MZM - Mozambican Metical</option>
                                                <option value="MMK" {{ old('currency', $user->currency) == 'MMK' ? "selected" : "" }}>MMK - Myanmar Kyat</option>
                                                <option value="NAD" {{ old('currency', $user->currency) == 'NAD' ? "selected" : "" }}>NAD - Namibian Dollar</option>
                                                <option value="NPR" {{ old('currency', $user->currency) == 'NPR' ? "selected" : "" }}>NPR - Nepalese Rupee</option>
                                                <option value="ANG" {{ old('currency', $user->currency) == 'ANG' ? "selected" : "" }}>ANG - Netherlands Antillean Guilder</option>
                                                <option value="TWD" {{ old('currency', $user->currency) == 'TWD' ? "selected" : "" }}>TWD - New Taiwan Dollar</option>
                                                <option value="NZD" {{ old('currency', $user->currency) == 'NZD' ? "selected" : "" }}>NZD - New Zealand Dollar</option>
                                                <option value="NIO" {{ old('currency', $user->currency) == 'NIO' ? "selected" : "" }}>NIO - Nicaraguan CÃ³rdoba</option>
                                                <option value="NGN" {{ old('currency', $user->currency) == 'NGN' ? "selected" : "" }}>NGN - Nigerian Naira</option>
                                                <option value="KPW" {{ old('currency', $user->currency) == 'KPW' ? "selected" : "" }}>KPW - North Korean Won</option>
                                                <option value="NOK" {{ old('currency', $user->currency) == 'NOK' ? "selected" : "" }}>NOK - Norwegian Krone</option>
                                                <option value="OMR" {{ old('currency', $user->currency) == 'OMR' ? "selected" : "" }}>OMR - Omani Rial</option>
                                                <option value="PKR" {{ old('currency', $user->currency) == 'PKR' ? "selected" : "" }}>PKR - Pakistani Rupee</option>
                                                <option value="PAB" {{ old('currency', $user->currency) == 'PAB' ? "selected" : "" }}>PAB - Panamanian Balboa</option>
                                                <option value="PGK" {{ old('currency', $user->currency) == 'PGK' ? "selected" : "" }}>PGK - Papua New Guinean Kina</option>
                                                <option value="PYG" {{ old('currency', $user->currency) == 'PYG' ? "selected" : "" }}>PYG - Paraguayan Guarani</option>
                                                <option value="PEN" {{ old('currency', $user->currency) == 'PEN' ? "selected" : "" }}>PEN - Peruvian Nuevo Sol</option>
                                                <option value="PHP" {{ old('currency', $user->currency) == 'PHP' ? "selected" : "" }}>PHP - Philippine Peso</option>
                                                <option value="PLN" {{ old('currency', $user->currency) == 'PLN' ? "selected" : "" }}>PLN - Polish Zloty</option>
                                                <option value="QAR" {{ old('currency', $user->currency) == 'QAR' ? "selected" : "" }}>QAR - Qatari Rial</option>
                                                <option value="RON" {{ old('currency', $user->currency) == 'RON' ? "selected" : "" }}>RON - Romanian Leu</option>
                                                <option value="RUB" {{ old('currency', $user->currency) == 'RUB' ? "selected" : "" }}>RUB - Russian Ruble</option>
                                                <option value="RWF" {{ old('currency', $user->currency) == 'RWF' ? "selected" : "" }}>RWF - Rwandan Franc</option>
                                                <option value="SVC" {{ old('currency', $user->currency) == 'SVC' ? "selected" : "" }}>SVC - Salvadoran ColÃ³n</option>
                                                <option value="WST" {{ old('currency', $user->currency) == 'WST' ? "selected" : "" }}>WST - Samoan Tala</option>
                                                <option value="SAR" {{ old('currency', $user->currency) == 'SAR' ? "selected" : "" }}>SAR - Saudi Riyal</option>
                                                <option value="RSD" {{ old('currency', $user->currency) == 'RSD' ? "selected" : "" }}>RSD - Serbian Dinar</option>
                                                <option value="SCR" {{ old('currency', $user->currency) == 'SCR' ? "selected" : "" }}>SCR - Seychellois Rupee</option>
                                                <option value="SLL" {{ old('currency', $user->currency) == 'SLL' ? "selected" : "" }}>SLL - Sierra Leonean Leone</option>
                                                <option value="SGD" {{ old('currency', $user->currency) == 'SGD' ? "selected" : "" }}>SGD - Singapore Dollar</option>
                                                <option value="SKK" {{ old('currency', $user->currency) == 'SKK' ? "selected" : "" }}>SKK - Slovak Koruna</option>
                                                <option value="SBD" {{ old('currency', $user->currency) == 'SBD' ? "selected" : "" }}>SBD - Solomon Islands Dollar</option>
                                                <option value="SOS" {{ old('currency', $user->currency) == 'SOS' ? "selected" : "" }}>SOS - Somali Shilling</option>
                                                <option value="ZAR" {{ old('currency', $user->currency) == 'ZAR' ? "selected" : "" }}>ZAR - South African Rand</option>
                                                <option value="KRW" {{ old('currency', $user->currency) == 'KRW' ? "selected" : "" }}>KRW - South Korean Won</option>
                                                <option value="XDR" {{ old('currency', $user->currency) == 'XDR' ? "selected" : "" }}>XDR - Special Drawing Rights</option>
                                                <option value="LKR" {{ old('currency', $user->currency) == 'KFR' ? "selected" : "" }}>LKR - Sri Lankan Rupee</option>
                                                <option value="SHP" {{ old('currency', $user->currency) == 'SHP' ? "selected" : "" }}>SHP - St. Helena Pound</option>
                                                <option value="SDG" {{ old('currency', $user->currency) == 'SDG' ? "selected" : "" }}>SDG - Sudanese Pound</option>
                                                <option value="SRD" {{ old('currency', $user->currency) == 'SRD' ? "selected" : "" }}>SRD - Surinamese Dollar</option>
                                                <option value="SZL" {{ old('currency', $user->currency) == 'SZL' ? "selected" : "" }}>SZL - Swazi Lilangeni</option>
                                                <option value="SEK" {{ old('currency', $user->currency) == 'SEK' ? "selected" : "" }}>SEK - Swedish Krona</option>
                                                <option value="CHF" {{ old('currency', $user->currency) == 'CHF' ? "selected" : "" }}>CHF - Swiss Franc</option>
                                                <option value="SYP" {{ old('currency', $user->currency) == 'SYP' ? "selected" : "" }}>SYP - Syrian Pound</option>
                                                <option value="STD" {{ old('currency', $user->currency) == 'STD' ? "selected" : "" }}>STD - São Tomé and Príncipe Dobra</option>
                                                <option value="TJS" {{ old('currency', $user->currency) == 'TJS' ? "selected" : "" }}>TJS - Tajikistani Somoni</option>
                                                <option value="TZS" {{ old('currency', $user->currency) == 'TZS' ? "selected" : "" }}>TZS - Tanzanian Shilling</option>
                                                <option value="THB" {{ old('currency', $user->currency) == 'THB' ? "selected" : "" }}>THB - Thai Baht</option>
                                                <option value="TOP" {{ old('currency', $user->currency) == 'TOP' ? "selected" : "" }}>TOP - Tongan pa'anga</option>
                                                <option value="TTD" {{ old('currency', $user->currency) == 'TTD' ? "selected" : "" }}>TTD - Trinidad & Tobago Dollar</option>
                                                <option value="TND" {{ old('currency', $user->currency) == 'TND' ? "selected" : "" }}>TND - Tunisian Dinar</option>
                                                <option value="TRY" {{ old('currency', $user->currency) == 'TRY' ? "selected" : "" }}>TRY - Turkish Lira</option>
                                                <option value="TMT" {{ old('currency', $user->currency) == 'TMT' ? "selected" : "" }}>TMT - Turkmenistani Manat</option>
                                                <option value="UGX" {{ old('currency', $user->currency) == 'UGX' ? "selected" : "" }}>UGX - Ugandan Shilling</option>
                                                <option value="UAH" {{ old('currency', $user->currency) == 'UAH' ? "selected" : "" }}>UAH - Ukrainian Hryvnia</option>
                                                <option value="AED" {{ old('currency', $user->currency) == 'AED' ? "selected" : "" }}>AED - United Arab Emirates Dirham</option>
                                                <option value="UYU" {{ old('currency', $user->currency) == 'UYU' ? "selected" : "" }}>UYU - Uruguayan Peso</option>
                                                <option value="USD" {{ old('currency', $user->currency) == 'USD' ? "selected" : "" }}>USD - US Dollar</option>
                                                <option value="UZS" {{ old('currency', $user->currency) == 'UZS' ? "selected" : "" }}>UZS - Uzbekistan Som</option>
                                                <option value="VUV" {{ old('currency', $user->currency) == 'VUV' ? "selected" : "" }}>VUV - Vanuatu Vatu</option>
                                                <option value="VEF" {{ old('currency', $user->currency) == 'VEF' ? "selected" : "" }}>VEF - Venezuelan BolÃ­var</option>
                                                <option value="VND" {{ old('currency', $user->currency) == 'VND' ? "selected" : "" }}>VND - Vietnamese Dong</option>
                                                <option value="YER" {{ old('currency', $user->currency) == 'YER' ? "selected" : "" }}>YER - Yemeni Rial</option>
                                                <option value="ZMK" {{ old('currency', $user->currency) == 'ZMK' ? "selected" : "" }}>ZMK - Zambian Kwacha</option>
                                            </select>
                                            @error('currency')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">Update Password</h5>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ url('/profile/password') }}" method="POST">
                                    @csrf
                                    
                                    <div class="row mb-3">
                                        <label class="form-label">Password:</label>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" required>
                                            @error('password')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label">Confirm Password:</label>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control" required>
                                            @error('password_confirmation')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit<i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /centered card -->

            </div>
        </div>
        <!-- /dashboard content -->

    </div>


    <div id="modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Crop & Resize your avatar</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>

				<div class="modal-body">
					<div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="{{ auth()->user()->avatar }}">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger crop-cancel" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
				</div>
			</div>
		</div>
    </div>

    


    <script>

        $('#avatar-upload').off('click').on('click', function(e){
            e.preventDefault();
            $("#avatar:hidden").trigger('click');
        });

        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;

        $("body").on("change", "#avatar", function(e){
            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };

            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        // Init cropper js when modal show and destroy cropper js when modal hide
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });


        $('.crop-cancel').off('click').on('click', function(){
            $modal.modal('hide');
        });

        $("#crop").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });

            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result; 
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: $('.basePath').attr('href') + "/profile/avatar",
                        data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
                        success: function(data){
                            $modal.modal('hide');
                            location.reload();
                        }
                    });
                }
            });
        });

    </script>
</x-layout>