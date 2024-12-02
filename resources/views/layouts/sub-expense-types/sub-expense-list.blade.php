@if (!$subExpenseTypes->isEmpty())
    <h6 class="text-center text-muted m-0 mb-1">Sub Expenses</h6>
    <a href="#" class="btn btn-sm btn-primary col-12 mb-2 calculate-amounts">Calculate & Set</a>

    <div class="row mb-3" style="max-height: 500px; overflow-y: auto">

        @foreach ($subExpenseTypes as $se)
            <div class="col-md-12 mb-1">
                <div class="form-floating">
                    <input type="number" class="form-control numeric-only sub-expense-amt" placeholder="Placeholder" name="sub_expense_{{ $se->id }}" value="{{ $se->amount }}">
                    <label>{{ $se->name }}</label>
                </div>
            </div>
        @endforeach

    </div>

    <script>
        $(document).ready(function() {
            $('.xub-expenses-wrapper').removeClass('d-none');
            $('.main-trn-form-container').addClass('col-md-8');
            $('.main-trn-form-container').removeClass('col-md-12');

            $('.calculate-amounts').off('click').on('click', function(e){
                e.preventDefault();

                var total = Number(0);
                $('.sub-expense-amt').each(function(i, item){
                    var amt = $(item).val();
                    if(amt == null || amt == '') amt = 0;
                    total += Number(amt);
                });

                $('#amount').val(total);

            })
        })
    </script>
@else
    <script>
        $(document).ready(function() {
            $('.xub-expenses-wrapper').addClass('d-none');
            $('.main-trn-form-container').removeClass('col-md-8');
            $('.main-trn-form-container').addClass('col-md-12');
        })
    </script>
@endif
