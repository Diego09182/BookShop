<div class="container">
	<div class="card blue-grey darken-1 card">
		<form name="BulletinForm" method="post" action="{{ route('bulletin.store', ['bulletin' => $bulletin->id]) }}">
			@csrf
			<div class="card-content white-text">
				<span class="card-title">公告主題</span>
				<div class="row">
					<div class="col m5 right">
						<h5>帳號:{{ Auth::user()->account }}</h5>
					</div>
				</div>
				<div class="row">
					<div class="input-field col m12">
						<i class="material-icons prefix">mode_edit</i>
						<input class="validate" name="title" type="text">
						<label for="icon_prefix2">公告主題</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col m12">
						<i class="material-icons prefix">mode_edit</i>
						<textarea class="materialize-textarea" name="content"></textarea>
						<label for="icon_prefix2">公告內容</label>
					</div>
				</div>
				<button class="waves-effect waves-light btn brown right" type="submit">發布公告</button>
				<br>
			</div>
		</form>
	</div>
</div>