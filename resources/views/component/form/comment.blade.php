<div id="modal1" class="modal">
    <div class="modal-content">
        <div class="card blue-grey darken-1">
            <form name="CommentForm" method="post" action="{{ route('comment.store', ['product' => $product->id]) }}">
                @csrf
                <div class="card-content white-text">
                    <span class="card-title">發布評論</span>
                    <div class="row">
                        <div class="col m5 right">
                            <h5>帳號:{{ Auth::user()->account }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <input class="validate" name="title" type="text">
                            <label for="icon_prefix2">主題</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea class="materialize-textarea" name="content"></textarea>
                            <label for="icon_prefix2">內容</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col m12">
                            <i class="material-icons prefix">star</i>
                            <input id="star" type="number" name="star" min="1" max="5">
                            <label for="star">星級評分 (1-5)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col m12">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat right">關閉</a>
                            <button class="waves-effect waves-light btn brown right" type="submit">發布評論</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
