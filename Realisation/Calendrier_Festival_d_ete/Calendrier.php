<!DOCTYPE html>

<html xmlns="http:www.w3.org/1999/xhtml">
	<head>
		<link rel="stylesheet" href="Joel.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
	</head>
	
	<body>

	<?php
	  // http://code.runnable.com/VKxpI5dzCMkTrRq1/simple-calendar-for-php
	  
		/* Set the default timezone */
		date_default_timezone_set("America/Montreal");

		/* Set the date */
		$date = strtotime("1 July 2015");   // NB : Il faut mettre A-JOUR cette ligne a chaque debut de mois.

		$day = date('d', $date);
		$month = date('m', $date);
		$year = date('Y', $date);
		
		$firstDay = mktime(0,0,0,$month, 1, $year);
		$title = strftime('%B', $firstDay);
		$dayOfWeek = date('D', $firstDay);
		$daysInMonth = cal_days_in_month(0, $month, $year);
		
		/* Get the name of the week days */
		$timestamp = strtotime('next Sunday');
		$weekDays = array();
		for ($i = 0; $i < 7; $i++) {
			$weekDays[] = strftime('%a', $timestamp);
			$timestamp = strtotime('+1 day', $timestamp);
		}
		
		$blank = date('w', strtotime("{$year}-{$month}-01"));
	?>
		<center>
			<!--------------------------------------------------------------------------------------------------------------->
				<table border="1">
					<tr>
						<td class="titre"> Temperature Quotidienne </td>
					</tr>
				</table>
			<!--------------------------------------------------------------------------------------------------------------->
			<table border="1">
				<tr>
                    <td class="mois_en_cours"> <?php echo $title; ?> <?php echo $year; ?> </td>
				</tr>
			</table>
			<!--------------------------------------------------------------------------------------------------------------->
			<table class='table table-bordered' style="table-layout: fixed;" >
				<tr>
					<?php foreach($weekDays as $key => $weekDay): ?>
						<td class="text-center"><?php echo $weekDay; ?></td>
					<?php endforeach ?>
				</tr>
				<!----------------------------------------------------------------------------------------------------------->
				<tr>
					<?php for($i=0 ; $i<$blank ; $i++): ?>
							 <td></td>
					<?php endfor; ?>
					
					<?php for($i=1 ; $i<=$daysInMonth ; $i++): ?>
						<?php if($day == $i): ?>
								<td class="day"><strong><?php echo $i; ?></strong></td>
						<?php else: ?>
								<td class="day"><?php echo $i; ?></td>
						<?php endif; ?>
						
						<?php if(($i + $blank) % 7 == 0): ?>
				</tr>
				
				<tr>
						<?php endif; ?>
					<?php endfor; ?>
					
					<?php for($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
						<td></td>
					<?php endfor; ?>
				</tr>
				
			</table>
			
			<!--------------------------------------------------------------------------------------------------------------->
			<table border="1">
				<tr>
                    <td class="titre"> Meilleur Jour pour aller au Festival d'ete </td>
				</tr>
			</table>
			
			<!--------------------------------------------------------------------------------------------------------------->
		    <table>
				<tr>
					<td>        </td> <td>     </td> <td>     </td> <td>        </td> <td>     </td> <td>        </td> <td>      </td>	
				</tr>
				<tr>
				    
					<td> <?php echo 'XX'; ?> Juillet </td> <td>     </td> <td>     </td> <td>        </td> <td>     </td> <td>        </td> <td>      </td>	
				</tr>
				<tr>
					<td>        </td> <td>     </td> <td>     </td> <td>        </td> <td>     </td> <td>        </td> <td>      </td>	
				</tr>
			</table>
			
			<!--------------------------------------------------------------------------------------------------------------->
			<table border="1">
				<tr>
                    <td class="titre"> Moyenne par periode de la journee </td>
				</tr>
			</table>
			
			<!--------------------------------------------------------------------------------------------------------------->
		    <table border="1">		
				<tr>
					<td>Matin</td> <td>Apres midi</td> <td>Soir</td> <td>Nuit</td> <td></td> <td></td> <td></td>
				</tr>
				<tr>
					<td class="day">        </td> <td class="day">     </td> <td class="day">     </td> <td class="day">        </td> <td>     </td> <td>        </td> <td>      </td>
				</tr>
				<tr>
					<td>        </td> <td>     </td> <td>     </td> <td>        </td> <td>     </td> <td>        </td> <td>      </td>	
				</tr>
				<tr>
					<td>        </td> <td>     </td> <td>     </td> <td>        </td> <td>     </td> <td>        </td> <td>      </td>	
				</tr>
			</table>
			<!--------------------------------------------------------------------------------------------------------------->
		</center>
		
	</body>	
	
	<?php include 'Data_Process.php' ; ?>
			
</html>