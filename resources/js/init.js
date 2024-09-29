	$(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('.fixed-action-btn').floatingActionButton({
			direction: 'left',
			hoverEnabled: false
		});
		$('.tabs').tabs();
		$('.parallax').parallax();
		$('.button-collapse').sidenav();
		$('.carousel.carousel-slider').carousel({ fullWidth: true });
		$('.modal').modal();
		$('.materialboxed').materialbox();
		$('.tooltipped').tooltip();
		$('.chips').chips();
		$('.collapsible').collapsible();
		$('.carousel').carousel();
		$('.slider').slider({ fullWidth: true });
		$('select').formSelect();
		$('.sidenav').sidenav();
	});

	const About = {
	template:
		`<div class="container">
			<div class="container">
				<developer></developer>
			</div>
		</div>` 
	}

	const Disclaimer = {
	template:
		`<div>		
			<liability></liability>			
			<terms></terms>			
			<serveterms></serveterms>
		</div>`
	}

	const Home = {
	template:
		`<div class="container">
			<serve></serve>
			<slogan></slogan>
		</div>`
	}
	
	const router = VueRouter.createRouter({
    	history: VueRouter.createWebHashHistory(),
    	routes : [
			{ path: '/', component: Home },
			{ path: '/home', component: Home },
			{ path: '/about', component: About },
			{ path: '/disclaimer', component: Disclaimer },
		],
  	});

	const app = Vue.createApp({
		data() {
			return {
					Home: '首頁',
					About: '關於網站',
					Disclaimer: '網站聲明',
				};
			},
		methods: {},
		watch: {},
		computed: {},
		mounted() {},
	});

	app.component('liability', {
		template:  
		`<div class="container">
			<div class="container">
				<div class="center-align">
					<h3>免責聲明</h3>
				</div>
				<div class="col s12 m12">
					<div class="card horizontal">
					<div class="card-stacked">
						<div class="card-content">
							<h4>
								<blockquote>
									開發者及運營者不為使用本站的用戶，負起其任何行為的法律責任。
								<br>
									對使用或連結本網頁而引致任何損害或其他無形損失，本網站不承擔任何賠償。
								</blockquote>
							</h4>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>`
	})
	
	app.component('terms', {
		template:  
		`<div class="container">
			<div class="container">
				<div class="center-align">
					<h3>使用者條款</h3>
				</div>
				<div class="col s12 m12">
					<div class="card horizontal">
						<div class="card-stacked">
							<div class="card-content">
								<h4>
									<blockquote>
										為了保障您的權益，請詳細閱讀本網站條款中的所有內容，尤其當您在完成註冊程序後，表示您已同意遵守會員條款的規範，並使用本網站所提供之服務。本站得視必要更新服務條款，不另特別通知。
									</blockquote>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>`
	})

	app.component('serveterms', {
		template:  
		`<div class="container">
			<div class="container">
				<div class="center-align">
					<h3>服務條款</h3>
				</div>
				<div class="col s12 m12">
					<div class="card horizontal">
						<div class="card-stacked">
							<div class="card-content">
								<h4>
									<blockquote>				                
										1.使用限制
										<br>
										1.1 您使用本網站必須遵守中華民國法律及網站的相關規定。
										<br>
										1.2 您不得利用本網站從事任何非法活動，包括但不限於傳播非法信息、侵犯他人權益等。
										<br>
										1.3 您必須尊重其他用戶的合法權益，不得在本網站上進行任何形式的侮辱、誹謗、威脅等行為。
										<br>
										2.使用風險與責任
										<br>
										2.1 您使用本網站所產生的任何風險和責任由您自行承擔，本網站不承擔任何責任。
										<br>
										2.2 您使用本網站時，應當注意保護個人隱私和資料安全，任何因您自身原因導致的資料泄露或其他損失，本網站不承擔責任。
										<br>
										3.免責聲明
										<br>
										3.1 本網站不承擔因使用本網站而產生的任何損失或損害責任，包括但不限於直接損失、間接損失、附帶損失、懲罰性損失等。
										<br>
										3.2 本網站不保證網站的可用性、可靠性、安全性、準確性、完整性和及時性。使用本網站的風險由您自行承擔。
										<br>
										4.修改與終止
										<br>
										4.1 本網站有權在任何時間修改本使用者條款，修改後的條款將立即生效。
										<br>
										4.2 本網站有權在任何時間終止網站的運營，終止後您將無法再使用本網站。
										<br>
										5.爭議解決
										<br>
										5.1 本使用者條款的解釋和適用，以及使用本網站產生的任何爭議，均受中華民國法律管轄。
										<br>
										5.2 任何因使用本網站產生的爭議，雙方應首先通過友好協商解決。如無法協商解決，任何一方均可向本網站所在地的有管轄權的法院提起訴訟。
										<br>
										6.其他條款
										<br>
										6.1 本使用者條款構成您與本網站之間的完整協議，並取代所有先前的口頭或書面協議。
										<br>
										6.2 如果本使用者條款中的任何條款被認定為無效或不可執行，該條款應被認為被取消，但該條款不影響其他條款的有效性和可執行性。
										<br>
										6.3 本使用者條款的標題僅作為參考之用，不具有法律效力。
										<br>
										如果您不同意本使用者條款的任何內容，請停止使用本網站。
									</blockquote>
								</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>`
	})

	app.component('slogan', {
	  template:  
		`<div>
			<div class="row">
				<div class="center-align col m12">
					<br>
					<h1 class="center-align"><b>SHOP</b></h1>
					<h4 class="center-align">
						<b>
							一個開源的線上商店應用程式
						</b>
					</h4>
					<br><br>
				</div>
			</div>
		</div>`
	})
	
	app.component('serve', {
	  template:  
		`<div class="row">
			<h3 class="center-align">主要服務</h3>
			<br>
			<div class="col s12 m4">
				<div class="icon-block">
					<h2 class="center light-brown-text"><i class="material-icons large ">shopping_cart</i></h2>
					<h5 class="center">提供線上銷售服務</h5>
					<p class="center">提供各式產品銷售</p>
				</div>
			</div>		
			<div class="col s12 m4">
			  	<div class="icon-block">
					<h2 class="center light-brown-text"><i class="material-icons large ">web</i></h2>
					<h5 class="center">資訊化管理</h5>
					<p class="center">以專業的應用程式管理產品</p>
			  	</div>
			</div>	
			<div class="col s12 m4">
			  	<div class="icon-block">
					<h2 class="center light-brown-text"><i class="material-icons large ">assessment</i></h2>
					<h5 class="center">相關統計資料</h5>
					<p class="center">秉持透明、開放的態度，公開部分統計資料</p>
			 	 </div>
			</div>
		</div>`
	})
	
	app.component('developer', {
		template:
		`<div class="row">
			<h3 class="center-align">開發者相關</h3>
			<div class="col s12 m12">
				<div class="card horizontal">
					<div class="card-image">
						<img src="images/SHOP.png">
					</div>
					<div class="card-stacked">
						<div class="card-content">
							<h4>一位初階Laravel開發者</h4>
							<h4>前端技術:Vue.js</h4>
							<h4>後端技術:Laravel</h4>
						</div>
						<div class="card-action">
							<a class="waves-effect waves-light btn black right" herf="https://github.com/Diego09182">Github</a>
						</div>
					</div>
				</div>
			</div>
		</div>`
	  })

	app.component('tool', {
	  template:  
		`<div class="fixed-action-btn horizontal click-to-toggle">
			<a class="btn-floating btn-large black">
				<i class="material-icons">menu</i>
			</a>
			<ul>
				<li><a href="#modal2" class="btn-floating btn waves-effect waves-light blue modal-trigger"><i class="tooltipped" data-position="top" data-tooltip="註冊"><i class="material-icons">assignment</i></i></a></li>
			</ul>
		</div>`
	})

	app.use(router);

	const vm = app.mount('#app');