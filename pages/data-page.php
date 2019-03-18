<?php include_once("../includes/headers.inc.php"); ?>
<!DOCTYPE html>
<html lang="en">
<body>
	<header>
		<?php
			$activePage = "dataPage";
			include_once("../includes/nav.inc.php");
		?>
	</header>
	<section class="section-main">
    <div class="data-main">
      <div class="data-title">
        <h2 id="title">Title</h2>
      </div>
      <div class="data-body">
        <div id="data-table">

        </div>
      </div>
    </div>
	</section>
	<section class="buttons">
		<button>Save</button>
		<button>Save and Export</button>
	</section>
	<div class="comment-box">
	</div>
</body>
</html>
