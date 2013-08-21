<div id="slidePresentation">
	<div id="slide">
		<?php

		 $themeOptions = get_option("gray_home_options");

		if($themeOptions["numslides"] == 1)
		{
			if(!empty($themeOptions["isHTML0"]))
			{

				echo $themeOptions["Slide0"];
			}
			else
			{
		?>
			<img class="fullSlideImage"src="<?php echo  $themeOptions["Slide0"] ?>">
			<?php
			}
		}
		else if($themeOptions["numslides"] > 1)
		{
			?>
			<div id="slideContainer">
				<ul id="slides">
					<?php 
					for($x = 0; $x < $themeOptions["numslides"]; $x++)
					{
						if(!empty($themeOptions["isHTML".$x]))
						{
							?>
							<li id="slide<?php echo $x; ?>"> <?php echo  $themeOptions["Slide" .$x] ?> </li>
							<?php
						}
						else
						{
							?>
								<li id="slide<?php echo $x; ?>" ><a><img class="fullSlideImage"src="<?php echo  $themeOptions["Slide" .$x] ?>"></img></a></li>
							<?php
						}
					}
					?>

				</ul>
			</div>
			<ul id="slideSelect"></ul>
			<a  id="slideLeft" ><div></div></a>
			<a id="slideRight"><div></div></a>
			<?php
		}
		else
		{
			echo "you must want to have somthing here ??";
		}
		?>
		<div id="slideBorder"></div>
	</div>
	<div id="blurb">
		<div id="blurbTitle"><?php echo  $themeOptions["blurbTitle"] ?></div>
		<div id="blurbInfo">
			<?php echo  $themeOptions["blurbStatement"] ?>
		</div>
	</div>
</div>
<div class="threeSplit">
	<div class="threeSplitElements"><div class="threeSplitContainer"><h1><?php echo  $themeOptions["leftHeader"] ?></h1><img src="<?php echo  $themeOptions["leftHeaderImage"] ?>" width="100" height="52px"></img><div class="threeInfoContent"><?php echo  $themeOptions["leftHeaderInfo"] ?></div></div></div>
	<div class="threeSplitElements"><div class="threeSplitContainer"><h1><?php echo  $themeOptions["middleHeader"] ?></h1><img src="<?php echo  $themeOptions["middleHeaderImage"] ?>" width="100" height="52px"></img><div class="threeInfoContent"><?php echo  $themeOptions["middleHeaderInfo"] ?></div></div></div>
	<div class="threeSplitElements"><div class="threeSplitContainer"><h1><?php echo  $themeOptions["rightHeader"] ?></h1><img src="<?php echo  $themeOptions["rightHeaderImage"] ?>" width="100" height="52px"></img><div class="threeInfoContent"><?php echo  $themeOptions["rightHeaderInfo"] ?> </div></div></div>
</div>