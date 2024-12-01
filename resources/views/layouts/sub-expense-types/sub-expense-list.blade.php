@if (!$subExpenseTypes->isEmpty())
    <h6 class="text-center text-muted">Sub Expenses</h6>

    <div class="row mb-3" style="max-height: 500px; overflow-y: auto">

        @foreach ($subExpenseTypes as $se)
            <div class="col-md-12 mb-1">
                <div class="form-floating">
                    <input type="number" class="form-control" placeholder="Placeholder" name="sub_expense_{{ $se->id }}" value="{{ $se->amount }}">
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
