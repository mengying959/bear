<?php
$countryName = ["臺北市" => ["中正區", "大同區", "中山區", "松山區", "大安區", "萬華區", "信義區", "士林區", "北投區", "內湖區", "南港區", "文山區"], "新北市" => [],];
require __DIR__ . '/parts/connect_db.php';
$pageName = 'home'; // 頁面名稱

if (isset($_GET['area'])) {
	$sql = "SELECT * FROM `map` WHERE `address` LIKE '%" . $_GET['area'] . "%' and `sort` LIKE '%". $_GET['sort']."%'";
} else {
	$sql = 'SELECT * FROM `map` WHERE 1 Limit 10';
}

$stmt = $pdo->query($sql);
?>
<?php include __DIR__ . '/parts/html-head.php'; ?>
<?php include __DIR__ . '/parts/navbar.php'; ?>
<div class="my_wrap">
	<div class="container">
		<div class="course_title">
			<h1>素食地圖</h1>
			<img src="/img/mascot_05.png" alt="">
		</div>

		<!-- 選單列表 -->
		<div class="formItem">
			<label>
				<div class="step">Step1</div>
				<select class="formItem1_select city" name="county" id="county_select">
					<option class="selet11" value="" <?php if (!isset($_GET['county'])) { ?> selected <?php } ?>>請選擇縣市</option>
					<option value="基隆市" <?php if ($_GET['county'] == '基隆市') { ?> selected <?php } ?>>基隆市</option>
					<option value="台北市" <?php if ($_GET['county'] == '台北市') { ?> selected <?php } ?>>台北市</option>
					<option value="新北市">新北市</option>
					<option value="桃園市">桃園市</option>
					<option value="新竹縣">新竹縣</option>
					<option value="新竹市">新竹市</option>
					<option value="苗栗縣">苗栗縣</option>
					<option value="彰化縣">彰化縣</option>
					<option value="台中市">台中市</option>
					<option value="南投縣">南投縣</option>
					<option value="雲林縣">雲林縣</option>
					<option value="嘉義縣">嘉義縣</option>
					<option value="嘉義市">嘉義市</option>
					<option value="台南市">台南市</option>
					<option value="高雄市">高雄市</option>
					<option value="屏東縣">屏東縣</option>
					<option value="宜蘭縣">宜蘭縣</option>
					<option value="花蓮縣">花蓮縣</option>
					<option value="台東縣">台東縣</option>
					<option value="澎湖縣">澎湖縣</option>
					<option value="連江縣">連江縣</option>
					<option value="金門縣">金門縣</option>
				</select>
			</label>

			<label>
				<div class="step">Step2</div>
				<select class="formItem1_select area" name="district" id="district_select" onchange="area()">
					<option class="selet11" value="" <?php if (!isset($_GET['area'])) { ?> selected <?php } ?>>請選擇地區</option> <?php foreach ($countryName["臺北市"] as $key => $value) { ?> <option value="<?php echo $value ?>" <?php if ($_GET['area'] == $value) { ?> selected <?php } ?>><?php echo $value ?></option> <?php } ?>
				</select>
			</label>
			<label>
				<div class="step">Step3</div>
				<select class="formItem1_select restType" name="restType" id="restType" onchange="sort()">
					<option value="" class="selet11" selected="">請選素食分類</option>
					<option value="全素" <?php if($_GET['sort'] == '全素'){echo 'selected';} ?>>全素</option>
					<option value="蛋素" <?php if($_GET['sort'] == '蛋素'){echo 'selected';} ?>>蛋素</option>
					<option value="五辛素" <?php if($_GET['sort'] == '五辛素'){echo 'selected';} ?>>五辛素</option>
					<option value="奶素" <?php if($_GET['sort'] == '奶素'){echo 'selected';} ?>>奶素</option>
					<option value="蛋奶素" <?php if($_GET['sort'] == '蛋奶素'){echo 'selected';} ?>>蛋奶素</option>
				</select>
			</label>
		</div>
		<!-- 地圖卡片 -->
		<!-- 顯示地圖用Bootstrap的互動式窗modal做 -->
		<?php
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

		?>
			<div class="mapcard">
				<div class="mappic">
					<img src="./img/map_img/<?php echo $row['img']; ?>.jpg" alt="">

					<!-- <img src="./img/map_img/<?php echo $row['img']; ?>.jpg" alt=""> -->
				</div>
				<div class="mapcardp">
					<div class="mapcardp1">
						<h3>
							<?php echo $row['name']; ?>
						</h3>
						<i class="fa-regular fa-bookmark"></i>
					</div>
					<div class="mapcardp2">
						<h4>
							<?php echo $row['address']; ?>
						</h4>
					</div>
					<div class="mapcardp3">
						<h4>
							<?php echo $row['time']; ?>
						</h4>
					</div>
					<div class="mapcardp4">
						<h4><?php echo $row['mobile']; ?>
						</h4>
					</div>
					<div class="mapcardp5">
						<span>
							<?php
								$sortArr = mb_split("/", $row['sort']);
								for ($i=0; $i < count($sortArr); $i++) { 
									echo "<h4>$sortArr[$i]</h4>";
								}
							?>
						
						</span>

						<!-- <button type="button" class="maplink" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    查看地圖
                </button> -->
						<a href="<?php echo $row['url']; ?>" target="_blank" class="maplink">查看地圖</a>
						<!-- <a href="" class="maplink">查看地圖</a> -->
					</div>

				</div>
			</div>
		<?php
		}

		?>

		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">map name</h5>
						<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
					</div>
					<div class="modal-body">
						<iframe src="https://g.page/ymspring03?share"></iframe>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>



		<!-- 頁面選單 -->
		<nav class="bigpageitem" aria-label="Page navigation example">
			<ul class="pagination">
				<li class="page-item">
					<a class="page-link" href="#" aria-label="Previous">
						<span aria-hidden="true"><i class="fa-solid fa-angle-left" aria-hidden="true"></i></span>
					</a>
				</li>
				<li class="page-item"><a class="page-link" href="#">1</a></li>
				<li class="page-item"><a class="page-link" href="#">2</a></li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item"><a class="page-link" href="#">4</a></li>
				<li class="page-item"><a class="page-link" href="#">5</a></li>
				<li class="page-item">
					<a class="page-link" href="#" aria-label="Next">
						<span aria-hidden="true"><i class="fa-solid fa-angle-right"></i></span>
					</a>
				</li>
			</ul>
		</nav>

	</div>
</div>

<?php include __DIR__ . '/parts/scripts.php'; ?>

<?php include __DIR__ . '/parts/html-foot.php'; ?>