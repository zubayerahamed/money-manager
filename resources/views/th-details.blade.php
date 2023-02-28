<x-layout pageTitle="Transaction Details">

    <!-- Content area -->
    <div class="content">
        <!-- Dashboard content -->
        <div class="row">

            <div class="col-xl-12">
                <!-- Marketing campaigns -->
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Transaction Details</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            @if (!$thDetails)
                                No transactions found
                            @endif
                            @foreach ($thDetails as $key => $val)
                                <table class="table text-nowrap" style="margin-bottom: 20px;">
                                    <thead>
                                        <tr style="background:rgb(224, 222, 221); color:">
                                            <th>{{ $key }}</th>
                                            <th style="text-align: right;">
                                                <span
                                                    style="color: green; font-weight: bold">{{ $val['income'] }}</span>
                                                <span style="color: rgb(9, 31, 238); font-weight: bold">/</span>
                                                <span style="color: red; font-weight: bold">{{ $val['expense'] }}</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($val['data'] as $trn)
                                            <tr>
                                                @if ($trn->transaction_type == 'INCOME')
                                                    <td class="text-success"><b>{{ $trn->amount }} TK</b> income from
                                                        <b
                                                            style="text-transform: uppercase;">{{ $trn->incomeSource->name }}</b>
                                                    </td>
                                                @elseif ($trn->transaction_type == 'EXPENSE')
                                                    <td class="text-danger"><b>{{ $trn->amount }} TK</b> expense for <b
                                                            style="text-transform: uppercase;">{{ $trn->expenseType->name }}</b>
                                                    </td>
                                                @else
                                                    <td class="text-primary"><b>{{ $trn->amount }} TK</b> transfer from
                                                        <b
                                                            style="text-transform: uppercase;">{{ $trn->fromWallet->name }}</b>
                                                        to <b
                                                            style="text-transform: uppercase;">{{ $trn->toWallet->name }}</b>
                                                    </td>
                                                @endif
                                                <td style="text-align: right">
                                                    <a href="{{ url('/tracking/detail/' . $trn->id . '/edit') }}"
                                                        title="Edit"><i class="far fa-edit"></i></a>
                                                    <form id="form-id{{ $trn->id }}"
                                                        action="{{ url('/tracking/detail/' . $trn->id . '/delete') }}"
                                                        method="POST" style="display: inline-block;">
                                                        @method('DELETE')
                                                        @csrf
                                                        <a href="#"
                                                            onclick="document.getElementById({{ 'form-id'.$trn->id }}).submit();"
                                                            class="text-danger" title="Delete"><i
                                                                class="far fa-trash-alt"></i></a>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>



                </div>
                <!-- /marketing campaigns -->
            </div>
        </div>
        <!-- /dashboard content -->
    </div>
    <!-- /content area -->

    <script></script>

</x-layout>
