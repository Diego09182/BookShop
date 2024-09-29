<div class="container">
    <div class="card blue-grey darken-1">
        <div class="card-content">
            <form action="{{ route('coupon.store') }}" method="POST">
                @csrf
                <div class="input-field">
                    <input type="text" id="code" name="code" class="validate">
                    <label for="code">折價卷代碼</label>
                </div>
                <div class="input-field">
                    <input type="date" id="date" name="date" class="datepicker">
                    <label for="date">有效期限</label>
                </div>
                <div class="input-field">
                    <input type="number" id="discount_amount" name="discount_amount" class="validate">
                    <label for="discount_amount">折扣金額</label>
                </div>
                <div class="input-field">
                    <input type="number" id="times" name="times" class="validate">
                    <label for="times">使用次數</label>
                </div>
                <button class="btn waves-effect waves-light black" type="submit">提交</button>
            </form>
        </div>
    </div>
</div>
