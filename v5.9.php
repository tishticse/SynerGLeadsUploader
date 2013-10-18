<?php
	if (!$link = mysql_connect('localhost', 'root', 'admin')) 
	{
		echo 'Could not connect to mysql';
		exit;
	}
	
	if (!mysql_select_db('nonvoice', $link)) 
	{
		echo 'Could not select database';
		exit;
	}
	
	$scorer = "ARPIOGorospeME";
	$fileID = "sample";
	$selectedYear = 2013;
	$selectedMonth = 10;
	$upperRangeSelectedDate = '2013-11-09';
	$lowerRangeSelectedDate = '2013-10-09';
	
	//                          ---------------- Queries for All the contents of the Database -----------------
	//Query for Scorer with bad scores 10 and below:
	$bsd10b = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name, customer_name, call_id,
		call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing <= 9 && scorer = '$scorer' && processing != call_duration";
	$resultbsd10b = mysql_query($bsd10b, $link);
	$bst10b = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing <= 9 && scorer = '$scorer' && processing != call_duration";
	$resultbst10b = mysql_query($bst10b, $link);
	//Query for Scorer with bad scores 11 to 20:
	$bsd1120 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name, customer_name, call_id,
		call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 11 AND processing <= 20 && call_duration NOT BETWEEN 11 AND 60 &&
		scorer = '$scorer'";
	$resultbsd1120 = mysql_query($bsd1120, $link);
	$bst1120 =  "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 11 AND processing <= 20 && call_duration NOT BETWEEN 11 AND 60 && scorer = '$scorer'";
	$resultbst1120 = mysql_query($bst1120, $link);
	//Query for Scorer with bad scores 21 to 30:
	$bsd2130 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name, customer_name, call_id,
		call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 21 AND processing <= 30 && call_duration NOT BETWEEN 21 AND 60 &&
		scorer = '$scorer'";
	$resultbsd2130 = mysql_query($bsd2130, $link);
	$bst2130 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 21 AND processing <= 30 && call_duration NOT BETWEEN 21 AND 60 &&
		scorer = '$scorer'";
	$resultbst2130 = mysql_query($bst2130, $link);
	//Query for Scorer with scores 31 to 40:
	$bsd3140 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name, customer_name, call_id,
		call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 31 AND processing <= 40 && call_duration NOT BETWEEN 31 AND 60
		&& scorer = '$scorer'";
	$resultbsd3140 = mysql_query($bsd3140, $link);
	$tst3140 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 31 AND processing <= 40 && call_duration NOT BETWEEN 31 AND 60
		&& scorer = '$scorer'";
	$resultbst3140 = mysql_query($tst3140, $link);
	//Query for Scorer with scores 41 to 50:
	$bsd4150 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name, customer_name, call_id,
		call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 41 AND processing <= 50 && scorer = '$scorer' && call_duration
		NOT BETWEEN 41 AND 60 && processing < 45";
	$resultbsd4150 = mysql_query($bsd4150, $link);
	$bst4150 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 41 AND processing <= 50 && call_duration NOT BETWEEN 41 AND 60 &&
		scorer = '$scorer' && processing < 45";
	$resultbst4150 = mysql_query($bst4150, $link);
	//Query for Scorer with scores 51 to 60:
	$bsd5160 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name, customer_name, call_id,
		call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 51 AND processing <= 60 && call_duration < 51 && scorer = '$scorer'";
	$resultbsd5160 = mysql_query($bsd5160, $link);
	$bst5160 =  "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 51 AND processing <= 60 && call_duration < 51 && scorer = '$scorer'";
	$resultbst5160 = mysql_query($bst5160, $link);
	//Query for Scorer with scores 61 and above:
	$bsd61a = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name, customer_name, call_id,
		call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 61 && call_duration < 61 && scorer = '$scorer'";
	$resultbsd61a = mysql_query($bsd61a, $link);
	$bst61a = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 61 && call_duration < 61 && scorer = '$scorer'";
	$resultbst61a = mysql_query($bst61a, $link);
	
	
	// Queries for ALL totals
	$totalNoBadScores = "SELECT DISTINCT scorer, (SELECT COUNT(*) as totalResult FROM processed_data WHERE processing <= 9 && scorer = '$scorer' && 
		processing != call_duration) + (SELECT COUNT(*) as totalResult FROM processed_data WHERE processing >= 11 AND processing <= 20 && call_duration NOT BETWEEN 11
		AND 60 && scorer = '$scorer') + (SELECT COUNT(*) as totalResult FROM processed_data WHERE processing >= 21 AND processing <= 30 && call_duration NOT BETWEEN 21
		AND 60 && scorer = '$scorer') + (SELECT COUNT(*) as totalResult FROM processed_data WHERE processing >= 31 AND processing <= 40 && call_duration NOT BETWEEN 31
		AND 60 && scorer = '$scorer') + (SELECT COUNT(*) as totalResult FROM processed_data WHERE processing >= 41 AND processing <= 50 && call_duration NOT BETWEEN 41
		AND 60 && scorer = '$scorer' && processing < 45) + (SELECT COUNT(*) as totalResult FROM processed_data WHERE processing >= 51 AND processing <= 60 &&
		scorer = '$scorer') + (SELECT COUNT(*) as totalResult FROM processed_data WHERE processing >= 61 && call_duration < 61 && scorer = '$scorer') AS total FROM
		processed_data WHERE scorer = '$scorer'";
	$resultTotalNoBadScores = mysql_query($totalNoBadScores, $link);
	
	$totalBadScores = "SELECT DISTINCT scorer, (SELECT SUM(processing) as totalResult FROM processed_data WHERE processing >= 11 AND processing <= 20 && call_duration
		NOT BETWEEN 11 AND 60 && scorer = '$scorer') + (SELECT SUM(processing) as totalResult FROM processed_data WHERE processing <= 9 && scorer = '$scorer' &&
		processing != call_duration) + (SELECT SUM(processing) as totalResult FROM processed_data WHERE processing >= 21 AND processing <= 30 && call_duration
		NOT BETWEEN 21 AND 60 && scorer = '$scorer') + (SELECT SUM(processing) as totalResult FROM processed_data WHERE processing >= 31 AND processing <= 40
		&& call_duration NOT BETWEEN 31 AND 60 && scorer = '$scorer') + (SELECT SUM(processing) as totalResult FROM processed_data WHERE processing >= 41 AND
		processing <= 50 && call_duration NOT BETWEEN 41 AND 60 && scorer = '$scorer' && processing < 45) + (SELECT SUM(processing) as totalResult FROM processed_data
		WHERE processing >= 51 AND processing <= 60 && call_duration < 51 && scorer = '$scorer') + (SELECT SUM(processing) as totalResult FROM processed_data WHERE
		processing >= 61 && call_duration < 61 && scorer = '$scorer')AS total FROM processed_data WHERE scorer = '$scorer'";
	$resultTotalBadScores = mysql_query($totalBadScores, $link);
	
	$averageBadScores = "SELECT DISTINCT scorer, ((SELECT AVG(processing) as totalResult FROM processed_data WHERE processing >= 11 AND processing <= 20 && call_duration
		NOT BETWEEN 11 AND 60 && scorer = '$scorer') + (SELECT AVG(processing) as totalResult FROM processed_data WHERE processing <= 9 && scorer = '$scorer' &&
		processing != call_duration) + (SELECT AVG(processing) as totalResult FROM processed_data WHERE processing >= 21 AND processing <= 30 && call_duration NOT BETWEEN
		21 AND 60 && scorer = '$scorer') + (SELECT AVG(processing) as totalResult FROM processed_data WHERE processing >= 31 AND processing <= 40 && call_duration
		NOT BETWEEN 31 AND 60 && scorer = '$scorer') + (SELECT AVG(processing) as totalResult FROM processed_data WHERE processing >= 41 AND processing <= 50 && 
		call_duration NOT BETWEEN 41 AND 60 && scorer = '$scorer' && processing < 45) + (SELECT AVG(processing) as totalResult FROM processed_data WHERE processing >= 51
		AND processing <= 60 && call_duration < 51 && scorer = '$scorer') + (SELECT AVG(processing) as totalResult FROM processed_data WHERE processing >= 61 &&
		call_duration < 61 && scorer = '$scorer')) / 7 AS total FROM processed_data WHERE scorer = '$scorer'";
	$resultAverageBadScores = mysql_query($averageBadScores, $link);


	//                           ------------------- Queries for Loading Chosen Files ---------------------
	//Query for Scorer with scores 10 and below for a chosen file:
	$tsfd10b = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing <= 10 && scorer = '$scorer' 
		&& file_id = '$fileID'";
	$resulttsfd10b = mysql_query($tsfd10b, $link);
	$tsft10b =  "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing <= 10 && file_id = '$fileID' && scorer = '$scorer'";
	$resulttsft10b = mysql_query($tsft10b, $link);
	//Query for Scorer with scores 11 to 20 for a chosen file:
	$tsfd1120 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 11 AND processing <= 20 
		&& scorer = '$scorer' && file_id = '$fileID'";
	$resulttsfd1120 = mysql_query($tsfd1120, $link);
	$tsft1120 =  "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 11 AND processing <= 20 && file_id = '$fileID'
		&& scorer = '$scorer'";
	$resulttsft1120 = mysql_query($tsft1120, $link);
	//Query for Scorer with scores 21 to 30 for a chosen file:
	$tsfd2130 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 21 AND processing <= 30
		&& scorer = '$scorer' && file_id = '$fileID'";
	$resulttsfd2130 = mysql_query($tsfd2130, $link);
	$tsft2130 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 21 AND processing <= 30 && file_id = '$fileID'
		&& scorer = '$scorer'";
	$resulttsft2130 = mysql_query($tsft2130, $link);
	//Query for Scorer with scores 31 to 40 for a chosen file:
	$tsfd3140 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 31 AND processing <= 40
		&& scorer = '$scorer' && file_id = '$fileID'";
	$resulttsd3140 = mysql_query($tsfd3140, $link);
	$tsft3140 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 31 AND processing <= 40 && file_id = '$fileID'
		&& scorer = '$scorer'";
	$resulttst3140 = mysql_query($tsft3140, $link);
	//Query for Scorer with scores 41 to 50 for a chosen file:
	$tsfd4150 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 41 AND processing <= 50
		&& scorer = '$scorer' && file_id = '$fileID'";
	$resulttsfd4150 = mysql_query($tsfd4150, $link);
	$tsft4150 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 41 AND processing <= 50 && file_id = '$fileID'
		&& scorer = '$scorer'";
	$resulttsft4150 = mysql_query($tsft4150, $link);
	//Query for Scorer with scores 51 to 60 for a chosen file:
	$tsfd5160 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 51 AND processing <= 60
		&& scorer = '$scorer' && file_id = '$fileID'";
	$resulttsfd5160 = mysql_query($tsfd5160, $link);
	$tsft5160 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 51 AND processing <= 60 && file_id = '$fileID'
		&& scorer = '$scorer'";
	$resulttsft5160 = mysql_query($tsft5160, $link);
	//Query for Scorer with scores 61 and above for a chosen file:
	$tsfd61a = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 61 && scorer = '$scorer'
		&& file_id = '$fileID'";
	$resulttsfd61a = mysql_query($tsfd61a, $link);
	$tsft61a = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 61 && file_id = '$fileID' && scorer = '$scorer'";
	$resulttsft61a = mysql_query($tsft61a, $link);
	
	// Queries for ALL totals for chosen files
	$totalNoScoresF = "SELECT scorer, COUNT(processing) as total FROM processed_data WHERE scorer = '$scorer' && file_id = '$fileID'";
	$resultTotalNoScoresF = mysql_query($totalNoScoresF, $link);
	$totalScoresF = "SELECT scorer, SUM(processing) as total FROM processed_data WHERE scorer = '$scorer' && file_id = '$fileID'";
	$resultTotalScoresF = mysql_query($totalScoresF, $link);
	$averageScoresF = "SELECT scorer, AVG(processing) as total FROM processed_data WHERE scorer = '$scorer' && file_id = '$fileID'";
	$resultAverageScoresF = mysql_query($averageScoresF, $link);
	
	
	//                           ------------------- Queries for Loading Chosen Year and Month ---------------------
	//Query for Scorer with scores 10 and below for chosen month and year:
	$tsmyd10b = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing <= 10 && scorer = '$scorer'
		&& year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyd10b = mysql_query($tsmyd10b, $link);
	$tsmyt10b = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE  processing <= 10 && scorer = '$scorer' &&
		year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyt10b = mysql_query($tsmyt10b, $link);
	//Query for Scorer with scores 11 to 20 for chosen month and year:
	$tsmyd1120 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 11 AND processing <= 20
		&& scorer = '$scorer' && year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyd1120 = mysql_query($tsmyd1120, $link);
	$tsmyt1120 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 11 AND processing <= 20 && scorer = '$scorer'
		&& year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyt1120 = mysql_query($tsmyt1120, $link);
	//Query for Scorer with scores 21 to 30 for chosen month and year:
	$tsmyd2130 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 21 AND processing <= 30
		&& scorer = '$scorer' && year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyd2130 = mysql_query($tsmyd2130, $link);
	$tsmyt2130 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 21 AND processing <= 30 && scorer = '$scorer'
		&& year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyt2130 = mysql_query($tsmyt2130, $link);
	//Query for Scorer with scores 31 to 40 for chosen month and year:
	$tsmyd3140 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 31 AND processing <= 40
		&& scorer = '$scorer' && year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyd3140 = mysql_query($tsmyd3140, $link);
	$tsmyt3140 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 31 AND processing <= 40 && scorer = '$scorer'
		&& year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyt3140 = mysql_query($tsmyt3140, $link);
	//Query for Scorer with scores 41 to 50 for chosen month and year:
	$tsmyd4150 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 41 AND processing <= 50
		&& scorer = '$scorer' && year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyd4150 = mysql_query($tsmyd4150, $link);
	$tsmyt4150 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 41 AND processing <= 50 && scorer = '$scorer'
		&& year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyt4150 = mysql_query($tsmyt4150, $link);
	//Query for Scorer with scores 51 to 60 for chosen month and year:
	$tsmyd5160 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 51 AND processing <= 60
		&& scorer = '$scorer' && year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyd5160 = mysql_query($tsmyd5160, $link);
	$tsmyt5160 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 51 AND processing <= 60 && scorer = '$scorer'
		&& year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyt5160 = mysql_query($tsmyt5160, $link);
	//Query for Scorer with scores 61 and above for chosen month and year:
	$tsmyd61a = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 61 && scorer = '$scorer'
		&& year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyd61a = mysql_query($tsmyd61a, $link);
	$tsmyt61a =  "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 61 && scorer = '$scorer' 
		&& year(upload_date) = '$selectedYear' && month(upload_date) = '$selectedMonth'";
	$resulttsmyt61a = mysql_query($tsmyt61a, $link);
	
	
	// Queries for ALL totals for selected year and month
	$totalNoScoresMY = "SELECT scorer, COUNT(processing) as total FROM processed_data WHERE scorer = '$scorer' && year(upload_date) = '$selectedYear'
		&& month(upload_date) = '$selectedMonth'";
	$resultTotalNoScoresMY = mysql_query($totalNoScoresMY, $link);
	$totalScoresMY = "SELECT scorer, SUM(processing) as total FROM processed_data WHERE scorer = '$scorer' && year(upload_date) = '$selectedYear'
		&& month(upload_date) = '$selectedMonth'";
	$resultTotalScoresMY = mysql_query($totalScoresMY, $link);
	$averageScoresMY = "SELECT scorer, AVG(processing) as total FROM processed_data WHERE scorer = '$scorer' && year(upload_date) = '$selectedYear'
		&& month(upload_date) = '$selectedMonth'";
	$resultAverageScoresMY = mysql_query($averageScoresMY, $link);
	
	//                           ------------------- Queries for Loading with a Range of Date ---------------------
	// Query for Scorer with scores 10 and below for a range of date:
	$tsrd10b = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing <= 10 && scorer = '$scorer'
		&& upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate') ";
	$resulttsrd10b = mysql_query($tsrd10b, $link);
	$tsrt10b = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing <= 10 && scorer = '$scorer' && upload_date
		BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resulttsrt10b = mysql_query($tsrt10b, $link);
	//Query for Scorer with scores 11 to 20  for a range of date:
	$tsrd1120 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 11 AND processing <= 20
		&& scorer = '$scorer' && upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate') ";
	$resulttsrd1120 = mysql_query($tsrd1120, $link);
	$tsrt1120 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 11 AND processing <= 20 && scorer = '$scorer'
		&& upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resulttsrt1120 = mysql_query($tsrt1120, $link);
	// Query for Scorer with scores 21 to 30  for a range of date:
	$tsrd2130 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 21 AND processing <= 30
		&& scorer = '$scorer' && upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate') ";
	$resulttsrd2130 = mysql_query($tsrd2130, $link);
	$tsrt2130 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 21 AND processing <= 30 && scorer = '$scorer'
		&& upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resulttsrt2130 = mysql_query($tsrt2130, $link);
	// Query for Scorer with scores 31 to 40  for a range of date:
	$tsrd3140 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 31 AND processing <= 40
		&& scorer = '$scorer' && upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate') ";
	$resulttsrd3140 = mysql_query($tsrd3140, $link);
	$tsrt3140 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 31 AND processing <= 40 && scorer = '$scorer'
		&& upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resulttsrt3140 = mysql_query($tsrt3140, $link);
	// Query for Scorer with scores 41 to 50  for a range of date:
	$tsrd4150 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 41 AND processing <= 50
		&& scorer = '$scorer' && upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate') ";
	$resulttsrd4150 = mysql_query($tsrd4150, $link);
	$tsrt4150 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 41 AND processing <= 50 && scorer = '$scorer'
		&& upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resulttsrt4150 = mysql_query($tsrt4150, $link);
	// Query for Scorer with scores 51 to 60  for a range of date:
	$tsrd5160 = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 51 AND processing <= 60
		&& scorer = '$scorer' && upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate') ";
	$resulttsrd5160 = mysql_query($tsrd5160, $link);
	$tsrt5160 = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 51 AND processing <= 60 && scorer = '$scorer'
		&& upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resulttsrt5160 = mysql_query($tsrt5160, $link);
	// Query for Scorer with scores 60 and above  for a range of date:
	$tsrd61a = "SELECT scorer, upload_date, file_id, call_start_time, processing_start, processing_end, processing, industry, account_name,
		customer_name, call_id, call_type, call_status, call_duration, audio_url FROM processed_data WHERE processing >= 61 && scorer = '$scorer' 
		&& upload_date BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate') ";
	$resulttsrd61a = mysql_query($tsrd61a, $link);
	$tsrt61a = "SELECT scorer, COUNT(*) as totalResult FROM processed_data WHERE processing >= 61 && scorer = '$scorer' && upload_date 
		BETWEEN date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resulttsrt61a = mysql_query($tsrt61a, $link);
	
	// Queries for ALL totals for range of date
	$totalNoScoresR = "SELECT scorer, COUNT(processing) as total FROM processed_data WHERE scorer = '$scorer' && upload_date BETWEEN
		date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resultTotalNoScoresR = mysql_query($totalNoScoresR, $link);
	$totalScoresR = "SELECT scorer, SUM(processing) as total FROM processed_data WHERE scorer = '$scorer' && upload_date BETWEEN
		date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resultTotalScoresR = mysql_query($totalScoresR, $link);
	$averageScoresR = "SELECT scorer, AVG(processing) as total FROM processed_data WHERE scorer = '$scorer' && upload_date BETWEEN
		date('$lowerRangeSelectedDate') AND date('$upperRangeSelectedDate')";
	$resultAverageScoresR = mysql_query($averageScoresR, $link);


	if (!$resultbsd10b || !$resultbst10b || !$resultbsd1120 || !$resultbst1120 || !$resultbsd2130 || !$resultbst2130 || !$resultbsd3140 || 
		!$resultbst3140 || !$resultbsd4150 || !$resultbst4150 || !$resultbsd5160 || !$resultbst5160 || !$resultbsd61a || !$resultbst61a ||
		!$resultTotalNoBadScores || !$resultTotalBadScores || !$resultAverageBadScores || !$resulttsfd10b || !$resulttsft10b || !$resulttsfd1120 ||
		!$resulttsft1120 || !$resulttsfd2130 || !$resulttsft2130 || !$resulttsd3140 || !$resulttst3140 || !$resulttsfd4150 || !$resulttsft4150 ||
		!$resulttsfd5160 || !$resulttsft5160 || !$resulttsfd61a || !$resulttsft61a || !$resultTotalNoScoresF || !$resultTotalScoresF || !$resultAverageScoresF ||
		!$resulttsmyd10b || !$resulttsmyt10b || !$resulttsmyd1120 || !$resulttsmyt1120 || !$resulttsmyd2130 || !$resulttsmyt2130 ||
		!$resulttsmyd3140 || !$resulttsmyt3140 || !$resulttsmyd4150 || !$resulttsmyt4150 || !$resulttsmyd5160 || !$resulttsmyt5160 ||
		!$resulttsmyd61a || !$resulttsmyt61a || !$resultTotalNoScoresMY || !$resultTotalScoresMY || !$resultAverageScoresMY || !$resulttsrd10b ||
		!$resulttsrt10b || !$resulttsrd1120 || !$resulttsrt1120 || !$resulttsrd2130 || !$resulttsrt2130 || !$resulttsrd3140 || !$resulttsrt3140 ||
		!$resulttsrd4150 || !$resulttsrt4150 || !$resulttsrd5160 || !$resulttsrt5160 || !$resulttsrd61a | !$resulttsrt61a || !$resultTotalNoScoresR ||
		!$resultTotalScoresR || !$resultAverageScoresR) 
	{
		echo "DB Error, could not query the database\n";
		echo 'MySQL Error: ' . mysql_error();
		exit;
	}

	/*while ($row1 = mysql_fetch_assoc($resultbsd61a)) 
	{
		echo $row1['scorer'];
		echo $row1['upload_date'];
		echo $row1['file_id'];
		echo $row1['call_start_time'];
		echo $row1['processing_start'];
		echo $row1['processing_end'];
		echo $row1['processing'];
		echo $row1['industry'];
		echo $row1['account_name'];
		echo $row1['customer_name'];
		echo $row1['call_id'];
		echo $row1['call_type'];
		echo $row1['call_status'];
		echo $row1['call_duration'];
		echo $row1['audio_url'];
	}
	
	while ($row2 = mysql_fetch_assoc($resultbst61a)) 
	{
		echo $row2['scorer'];
		echo $row2['totalResult'];
	} */
	
	$total1 = mysql_fetch_assoc($resultTotalNoBadScores); 
	echo $total1['scorer'];
	echo $total1['total'];
	
	$total2 = mysql_fetch_assoc($resultTotalBadScores); 
	echo $total2['scorer'];
	echo $total2['total'];
	
	$total3 = mysql_fetch_assoc($resultAverageBadScores);
	echo $total3['scorer'];
	echo $total3['total']; 
	
	/*while ($row1 = mysql_fetch_assoc($resultbsd10b)) 
	{
		$scorer = $row1['scorer'];
		$upload_date = $row1['upload_date'];
		$file_id = $row1['file_id'];
		$call_start_time = $row1['call_start_time'];
		$processing_start = $row1['processing_start'];
		$processing_end = $row1['processing_end'];
		$processing = $row1['processing'];
		$industry = $row1['industry'];
		$account_name = $row1['account_name'];
		$customer_name = $row1['customer_name'];
		$call_id = $row1['call_id'];
		$call_type = $row1['call_type'];
		$call_status = $row1['call_status'];
		$call_duration = $row1['call_duration'];
		$audio_url = $row1['audio_url'];
	} */
	
	/*while ($row2 = mysql_fetch_assoc($resultbst10b)) 
	{
		$scorer = $row2['scorer'];
		$totalResult = $row2['totalResult'];
	} */
	
	/*while ($row3 = mysql_fetch_assoc($resultbsd1120)) 
	{
		$scorer = $row3['scorer'];
		$upload_date = $row3['upload_date'];
		$file_id = $row3['file_id'];
		$call_start_time = $row3['call_start_time'];
		$processing_start = $row3['processing_start'];
		$processing_end = $row3['processing_end'];
		$processing = $row3['processing'];
		$industry = $row3['industry'];
		$account_name = $row3['account_name'];
		$customer_name = $row3['customer_name'];
		$call_id = $row3['call_id'];
		$call_type = $row3['call_type'];
		$call_status = $row3['call_status'];
		$call_duration = $row3['call_duration'];
		$audio_url = $row3['audio_url'];
	} */
	
	/*while ($row4 = mysql_fetch_assoc($resultbst1120)) 
	{
		$scorer = $row4['scorer'];
		$totalResult = $row4['totalResult'];
	} */
	
	/*while ($row5 = mysql_fetch_assoc($resultbsd2130)) 
	{
		$scorer = $row5['scorer'];
		$upload_date = $row5['upload_date'];
		$file_id = $row5['file_id'];
		$call_start_time = $row5['call_start_time'];
		$processing_start = $row5['processing_start'];
		$processing_end = $row5['processing_end'];
		$processing = $row5['processing'];
		$industry = $row5['industry'];
		$account_name = $row5['account_name'];
		$customer_name = $row5['customer_name'];
		$call_id = $row5['call_id'];
		$call_type = $row5['call_type'];
		$call_status = $row5['call_status'];
		$call_duration = $row5['call_duration'];
		$audio_url = $row5['audio_url'];
	} */
	
	/*while ($row6 = mysql_fetch_assoc($resultbst2130)) 
	{
		$scorer = $row6['scorer'];
		$totalResult = $row6['totalResult'];
	} */
	
	/*while ($row7 = mysql_fetch_assoc($resultbsd3140)) 
	{
		$scorer = $row7['scorer'];
		$upload_date = $row7['upload_date'];
		$file_id = $row7['file_id'];
		$call_start_time = $row7['call_start_time'];
		$processing_start = $row7['processing_start'];
		$processing_end = $row7['processing_end'];
		$processing = $row7['processing'];
		$industry = $row7['industry'];
		$account_name = $row7['account_name'];
		$customer_name = $row7['customer_name'];
		$call_id = $row7['call_id'];
		$call_type = $row7['call_type'];
		$call_status = $row7['call_status'];
		$call_duration = $row7['call_duration'];
		$audio_url = $row7['audio_url'];
	}*/
	
	/*while ($row8 = mysql_fetch_assoc($resultbst3140)) 
	{
		$scorer = $row8['scorer'];
		$totalResult = $row8['totalResult'];
	} */
	
	/*while ($row9 = mysql_fetch_assoc($resultbsd4150)) 
	{
		$scorer = $row9['scorer'];
		$upload_date = $row9['upload_date'];
		$file_id = $row9['file_id'];
		$call_start_time = $row9['call_start_time'];
		$processing_start = $row9['processing_start'];
		$processing_end = $row9['processing_end'];
		$processing = $row9['processing'];
		$industry = $row9['industry'];
		$account_name = $row9['account_name'];
		$customer_name = $row9['customer_name'];
		$call_id = $row9['call_id'];
		$call_type = $row9['call_type'];
		$call_status = $row9['call_status'];
		$call_duration = $row9['call_duration'];
		$audio_url = $row9['audio_url'];
	} */
	
	/*while ($row10 = mysql_fetch_assoc($resultbst4150)) 
	{
		$scorer = $row10['scorer'];
		$totalResult = $row10['totalResult'];
	} */
	
	/*while ($row11 = mysql_fetch_assoc($resultbsd5160)) 
	{
		$scorer = $row11['scorer'];
		$upload_date = $row11['upload_date'];
		$file_id = $row11['file_id'];
		$call_start_time = $row11['call_start_time'];
		$processing_start = $row11['processing_start'];
		$processing_end = $row11['processing_end'];
		$processing = $row11['processing'];
		$industry = $row11['industry'];
		$account_name = $row11['account_name'];
		$customer_name = $row11['customer_name'];
		$call_id = $row11['call_id'];
		$call_type = $row11['call_type'];
		$call_status = $row11['call_status'];
		$call_duration = $row11['call_duration'];
		$audio_url = $row11['audio_url'];
	}*/
	
	/*while ($row12 = mysql_fetch_assoc($resultbst5160)) 
	{
		$scorer = $row12['scorer'];
		$totalResult = $row12['totalResult'];
	} */
	
	/*while ($row13 = mysql_fetch_assoc($resultbsd61a)) 
	{
		$scorer = $row13['scorer'];
		$upload_date = $row13['upload_date'];
		$file_id = $row13['file_id'];
		$call_start_time = $row13['call_start_time'];
		$processing_start = $row13['processing_start'];
		$processing_end = $row13['processing_end'];
		$processing = $row13['processing'];
		$industry = $row13['industry'];
		$account_name = $row13['account_name'];
		$customer_name = $row13['customer_name'];
		$call_id = $row13['call_id'];
		$call_type = $row13['call_type'];
		$call_status = $row13['call_status'];
		$call_duration = $row13['call_duration'];
		$audio_url = $row13['audio_url'];
	} */
	
	/*while ($row14 = mysql_fetch_assoc($resultbst61a)) 
	{
		$scorer = $row14['scorer'];
		$totalResult = $row14['totalResult'];
	} */

	/*$total1 = mysql_fetch_assoc($resultTotalNoBadScores); 
	$scorer = $total1['scorer'];
	$total = $total1['total'];
	
	$total2 = mysql_fetch_assoc($resultTotalBadScores); 
	$scorer = $total2['scorer'];
	$total = $total2['total'];
	
	$total3 = mysql_fetch_assoc($resultAverageBadScores);
	$scorer = $total3['scorer'];
	$total = $total3['total']; 
	*/
	
	/*while ($row15 = mysql_fetch_assoc($resulttsfd10b)) 
	{
		$scorer = $row15['scorer'];
		$upload_date = $row15['upload_date'];
		$file_id = $row15['file_id'];
		$call_start_time = $row15['call_start_time'];
		$processing_start = $row15['processing_start'];
		$processing_end = $row15['processing_end'];
		$processing = $row15['processing'];
		$industry = $row15['industry'];
		$account_name = $row15['account_name'];
		$customer_name = $row15['customer_name'];
		$call_id = $row15['call_id'];
		$call_type = $row15['call_type'];
		$call_status = $row15['call_status'];
		$call_duration = $row15['call_duration'];
		$audio_url = $row15['audio_url'];
	} */
	
	/*while ($row16 = mysql_fetch_assoc($resulttsft10b)) 
	{
		$scorer = $row16['scorer'];
		$totalResult = $row16['totalResult'];
	} */
	
	/*while ($row17 = mysql_fetch_assoc($resulttsfd1120)) 
	{
		$scorer = $row17['scorer'];
		$upload_date = $row17['upload_date'];
		$file_id = $row17['file_id'];
		$call_start_time = $row17['call_start_time'];
		$processing_start = $row17['processing_start'];
		$processing_end = $row17['processing_end'];
		$processing = $row17['processing'];
		$industry = $row17['industry'];
		$account_name = $row17['account_name'];
		$customer_name = $row17['customer_name'];
		$call_id = $row17['call_id'];
		$call_type = $row17['call_type'];
		$call_status = $row17['call_status'];
		$call_duration = $row17['call_duration'];
		$audio_url = $row17['audio_url'];
	} */
	
	/*while ($row18 = mysql_fetch_assoc($resulttsft1120)) 
	{
		$scorer = $row18['scorer'];
		$totalResult = $row18['totalResult'];
	} */
	
	/*while ($row19 = mysql_fetch_assoc($resulttsfd2130)) 
	{
		$scorer = $row19['scorer'];
		$upload_date = $row19['upload_date'];
		$file_id = $row19['file_id'];
		$call_start_time = $row19['call_start_time'];
		$processing_start = $row19['processing_start'];
		$processing_end = $row19['processing_end'];
		$processing = $row19['processing'];
		$industry = $row19['industry'];
		$account_name = $row19['account_name'];
		$customer_name = $row19['customer_name'];
		$call_id = $row19['call_id'];
		$call_type = $row19['call_type'];
		$call_status = $row19['call_status'];
		$call_duration = $row19['call_duration'];
		$audio_url = $row19['audio_url'];
	} */
	
	/* while ($row20 = mysql_fetch_assoc($resulttsft2130)) 
	{
		$scorer = $row20['scorer'];
		$totalResult = $row20['totalResult'];
	} */
	
	/*while ($row21 = mysql_fetch_assoc($resulttsfd3140)) 
	{
		$scorer = $row21['scorer'];
		$upload_date = $row21['upload_date'];
		$file_id = $row21['file_id'];
		$call_start_time = $row21['call_start_time'];
		$processing_start = $row21['processing_start'];
		$processing_end = $row21['processing_end'];
		$processing = $row21['processing'];
		$industry = $row21['industry'];
		$account_name = $row21['account_name'];
		$customer_name = $row21['customer_name'];
		$call_id = $row21['call_id'];
		$call_type = $row21['call_type'];
		$call_status = $row21['call_status'];
		$call_duration = $row21['call_duration'];
		$audio_url = $row21['audio_url'];
	} */
	
	/*while ($row22 = mysql_fetch_assoc($resulttsft3140)) 
	{
		$scorer = $row22['scorer'];
		$totalResult = $row22['totalResult'];
	} */
	
	/*while ($row23 = mysql_fetch_assoc($resulttsfd4150)) 
	{
		$scorer = $row23['scorer'];
		$upload_date = $row23['upload_date'];
		$file_id = $row23['file_id'];
		$call_start_time = $row23['call_start_time'];
		$processing_start = $row23['processing_start'];
		$processing_end = $row23['processing_end'];
		$processing = $row23['processing'];
		$industry = $row23['industry'];
		$account_name = $row23['account_name'];
		$customer_name = $row23['customer_name'];
		$call_id = $row23['call_id'];
		$call_type = $row23['call_type'];
		$call_status = $row23['call_status'];
		$call_duration = $row23['call_duration'];
		$audio_url = $row23['audio_url'];
	} */
	
	/*while ($row24 = mysql_fetch_assoc($resulttsft4150)) 
	{
		$scorer = $row24['scorer'];
		$totalResult = $row24['totalResult'];
	} */
	
	/*while ($row25 = mysql_fetch_assoc($resulttsfd5160)) 
	{
		$scorer = $row25['scorer'];
		$upload_date = $row25['upload_date'];
		$file_id = $row25['file_id'];
		$call_start_time = $row25['call_start_time'];
		$processing_start = $row25['processing_start'];
		$processing_end = $row25['processing_end'];
		$processing = $row25['processing'];
		$industry = $row25['industry'];
		$account_name = $row25['account_name'];
		$customer_name = $row25['customer_name'];
		$call_id = $row25['call_id'];
		$call_type = $row25['call_type'];
		$call_status = $row25['call_status'];
		$call_duration = $row25['call_duration'];
		$audio_url = $row25['audio_url'];
	} */
	
	/*while ($row26 = mysql_fetch_assoc($resulttsft5160)) 
	{
		$scorer = $row26['scorer'];
		$totalResult = $row26['totalResult'];
	} */
	
	/*while ($row27 = mysql_fetch_assoc($resulttsfd61a)) 
	{
		$scorer = $row27['scorer'];
		$upload_date = $row27['upload_date'];
		$file_id = $row27['file_id'];
		$call_start_time = $row27['call_start_time'];
		$processing_start = $row27['processing_start'];
		$processing_end = $row27['processing_end'];
		$processing = $row27['processing'];
		$industry = $row27['industry'];
		$account_name = $row27['account_name'];
		$customer_name = $row27['customer_name'];
		$call_id = $row27['call_id'];
		$call_type =  $row27['call_type'];
		$call_status = $row27['call_status'];
		$call_duration = $row27['call_duration'];
		$audio_url = $row27['audio_url'];
	} */
	
	/*while ($row28 = mysql_fetch_assoc($resulttsft61a)) 
	{
		$scorer = $row28['scorer'];
		$totalResult = $row28['totalResult'];
	} */
	
	/*$total4 = mysql_fetch_assoc($resultTotalNoScoresF); 
	$scorer = $total4['scorer'];
	$total = $total4['total'];
	$total5 = mysql_fetch_assoc($resultTotalScoresF); 
	$scorer = $total5['scorer'];
	$total = $total5['total'];
	$total6 = mysql_fetch_assoc($resultAverageScoresF); 
	$scorer = $total6['scorer'];
	$total = $total6['total'];
	*/
	
	/*while ($row28 = mysql_fetch_assoc($resulttsmyd10b)) 
	{
		$scorer = $row28['scorer'];
		$upload_date = $row28['upload_date'];
		$file_id = $row28['file_id'];
		$call_start_time = $row28['call_start_time'];
		$processing_start = $row28['processing_start'];
		$processing_end = $row28['processing_end'];
		$processing = $row28['processing'];
		$industry = $row28['industry'];
		$account_name = $row28['account_name'];
		$customer_name = $row28['customer_name'];
		$call_id = $row28['call_id'];
		$call_type =  $row28['call_type'];
		$call_status = $row28['call_status'];
		$call_duration = $row28['call_duration'];
		$audio_url = $row28['audio_url'];
	} */
	
	/*while ($row29 = mysql_fetch_assoc($resulttsmyt10b)) 
	{
		$scorer = $row29['scorer'];
		$totalResult = $row29['totalResult'];
	} */
	
	/*while ($row30 = mysql_fetch_assoc($resulttsmyd1120)) 
	{
		$scorer = $row30['scorer'];
		$upload_date = $row30['upload_date'];
		$file_id = $row30['file_id'];
		$call_start_time = $row30['call_start_time'];
		$processing_start = $row30['processing_start'];
		$processing_end = $row30['processing_end'];
		$processing = $row30['processing'];
		$industry = $row30['industry'];
		$account_name = $row30['account_name'];
		$customer_name = $row30['customer_name'];
		$call_id = $row30['call_id'];
		$call_type =  $row30['call_type'];
		$call_status = $row30['call_status'];
		$call_duration = $row30['call_duration'];
		$audio_url = $row30['audio_url'];
	} */
	
	/* while ($row31 = mysql_fetch_assoc($resulttsmyt1120)) 
	{
		$scorer = $row31['scorer'];
		$totalResult = $row31['totalResult'];
	} */
	
	/*while ($row32 = mysql_fetch_assoc($resulttsmyd2130)) 
	{
		$scorer = $row32['scorer'];
		$upload_date = $row32['upload_date'];
		$file_id = $row32['file_id'];
		$call_start_time = $row32['call_start_time'];
		$processing_start = $row32['processing_start'];
		$processing_end = $row32['processing_end'];
		$processing = $row32['processing'];
		$industry = $row32['industry'];
		$account_name = $row32['account_name'];
		$customer_name = $row32['customer_name'];
		$call_id = $row32['call_id'];
		$call_type =  $row32['call_type'];
		$call_status = $row32['call_status'];
		$call_duration = $row32['call_duration'];
		$audio_url = $row32['audio_url'];
	} */
	
	/* while ($row33 = mysql_fetch_assoc($resulttsmyt2130)) 
	{
		$scorer = $row33['scorer'];
		$totalResult = $row33['totalResult'];
	} */
	
	/*while ($row34 = mysql_fetch_assoc($resulttsmyd3140)) 
	{
		$scorer = $row34['scorer'];
		$upload_date = $row34['upload_date'];
		$file_id = $row34['file_id'];
		$call_start_time = $row34['call_start_time'];
		$processing_start = $row34['processing_start'];
		$processing_end = $row34['processing_end'];
		$processing = $row34['processing'];
		$industry = $row34['industry'];
		$account_name = $row34['account_name'];
		$customer_name = $row34['customer_name'];
		$call_id = $row34['call_id'];
		$call_type =  $row34['call_type'];
		$call_status = $row34['call_status'];
		$call_duration = $row34['call_duration'];
		$audio_url = $row34['audio_url'];
	} */
	
	/* while ($row35 = mysql_fetch_assoc($resulttsmyt3140)) 
	{
		$scorer = $row35['scorer'];
		$totalResult = $row35['totalResult'];
	} */
	
	/*while ($row36 = mysql_fetch_assoc($resulttsmyd4150)) 
	{
		$scorer = $row36['scorer'];
		$upload_date = $row36['upload_date'];
		$file_id = $row36['file_id'];
		$call_start_time = $row36['call_start_time'];
		$processing_start = $row36['processing_start'];
		$processing_end = $row36['processing_end'];
		$processing = $row36['processing'];
		$industry = $row36['industry'];
		$account_name = $row36['account_name'];
		$customer_name = $row36['customer_name'];
		$call_id = $row36['call_id'];
		$call_type =  $row36['call_type'];
		$call_status = $row36['call_status'];
		$call_duration = $row36['call_duration'];
		$audio_url = $row36['audio_url'];
	} */
	
	/* while ($row37 = mysql_fetch_assoc($resulttsmyt4150)) 
	{
		$scorer = $row37['scorer'];
		$totalResult = $row37['totalResult'];
	} */
	
	/*while ($row38 = mysql_fetch_assoc($resulttsmyd5160)) 
	{
		$scorer = $row38['scorer'];
		$upload_date = $row38['upload_date'];
		$file_id = $row38['file_id'];
		$call_start_time = $row38['call_start_time'];
		$processing_start = $row38['processing_start'];
		$processing_end = $row38['processing_end'];
		$processing = $row38['processing'];
		$industry = $row38['industry'];
		$account_name = $row38['account_name'];
		$customer_name = $row38['customer_name'];
		$call_id = $row38['call_id'];
		$call_type =  $row38['call_type'];
		$call_status = $row38['call_status'];
		$call_duration = $row38['call_duration'];
		$audio_url = $row38['audio_url'];
	}*/
	
	/*while ($row39 = mysql_fetch_assoc($resulttsmyt5160)) 
	{
		$scorer = $row39['scorer'];
		$totalResult = $row39['totalResult'];
	}*/
	
	/*while ($row40 = mysql_fetch_assoc($resulttsmyd61a)) 
	{
		$scorer = $row40['scorer'];
		$upload_date = $row40['upload_date'];
		$file_id = $row40['file_id'];
		$call_start_time = $row40['call_start_time'];
		$processing_start = $row40['processing_start'];
		$processing_end = $row40['processing_end'];
		$processing = $row40['processing'];
		$industry = $row40['industry'];
		$account_name = $row40['account_name'];
		$customer_name = $row40['customer_name'];
		$call_id = $row40['call_id'];
		$call_type = $row40['call_type'];
		$call_status = $row40['call_status'];
		$call_duration = $row40['call_duration'];
		$audio_url = $row40['audio_url'];
	} */
	
	/*while ($row41 = mysql_fetch_assoc($resulttsmyt61a)) 
	{
		$scorer = $row41['scorer'];
		$totalResult = $row41['totalResult'];
	} */
	
	/*$total7 = mysql_fetch_assoc($resultTotalNoScoresMY); 
	$scorer = $total7['scorer'];
	$total = $total7['total'];
	$total8 = mysql_fetch_assoc($resultTotalScoresMY); 
	$scorer = $total8['scorer'];
	$total = $total8['total'];
	$total9 = mysql_fetch_assoc($resultAverageScoresMY); 
	$call_duration = $total9['scorer'];
	$total = $total9['total'];
	*/
	
	/*while ($row42 = mysql_fetch_assoc($resulttsrd10b)) 
	{
		$scorer = $row42['scorer'];
		$upload_date = $row42['upload_date'];
		$file_id = $row42['file_id'];
		$call_start_time = $row42['call_start_time'];
		$processing_start = $row42['processing_start'];
		$processing_end = $row42['processing_end'];
		$processing = $row42['processing'];
		$industry = $row42['industry'];
		$account_name = $row42['account_name'];
		$customer_name = $row42['customer_name'];
		$call_id = $row42['call_id'];
		$call_type = $row42['call_type'];
		$call_status = $row42['call_status'];
		$call_duration = $row42['call_duration'];
		$audio_url = $row42['audio_url'];
	} */

	/*while ($row43 = mysql_fetch_assoc($resulttsrt10b)) 
	{
		$scorer = $row43['scorer'];
		$totalResult = $row43['totalResult'];
	} */
	
	/*while ($row44 = mysql_fetch_assoc($resulttsrd1120)) 
	{
		$scorer = $row44['scorer'];
		$upload_date = $row44['upload_date'];
		$file_id = $row44['file_id'];
		$call_start_time = $row44['call_start_time'];
		$processing_start = $row44['processing_start'];
		$processing_end = $row44['processing_end'];
		$processing = $row44['processing'];
		$industry = $row44['industry'];
		$account_name = $row44['account_name'];
		$customer_name = $row44['customer_name'];
		$call_id = $row44['call_id'];
		$call_type = $row44['call_type'];
		$call_status = $row44['call_status'];
		$call_duration = $row44['call_duration'];
		$audio_url = $row44['audio_url'];
	} */
	
	/*while ($row45 = mysql_fetch_assoc($resulttsrt1120)) 
	{
		$scorer = $row45['scorer'];
		$totalResult = $row45['totalResult'];
	} */
	
	/*while ($row46 = mysql_fetch_assoc($resulttsrd2130)) 
	{
		$scorer = $row46['scorer'];
		$upload_date = $row46['upload_date'];
		$file_id = $row46['file_id'];
		$call_start_time = $row46['call_start_time'];
		$processing_start = $row46['processing_start'];
		$processing_end = $row46['processing_end'];
		$processing = $row46['processing'];
		$industry = $row46['industry'];
		$account_name = $row46['account_name'];
		$customer_name = $row46['customer_name'];
		$call_id = $row46['call_id'];
		$call_type = $row46['call_type'];
		$call_status = $row46['call_status'];
		$call_duration = $row46['call_duration'];
		$audio_url = $row46['audio_url'];
	} */
	
	/*while ($row47 = mysql_fetch_assoc($resulttsrt2130)) 
	{
		$scorer = $row47['scorer'];
		$totalResult = $row47['totalResult'];
	} */
	
	/*while ($row48 = mysql_fetch_assoc($resulttsrd3140)) 
	{
		$scorer = $row48['scorer'];
		$upload_date = $row48['upload_date'];
		$file_id = $row48['file_id'];
		$call_start_time = $row48['call_start_time'];
		$processing_start = $row48['processing_start'];
		$processing_end = $row48['processing_end'];
		$processing = $row48['processing'];
		$industry = $row48['industry'];
		$account_name = $row48['account_name'];
		$customer_name = $row48['customer_name'];
		$call_id = $row48['call_id'];
		$call_type = $row48['call_type'];
		$call_status = $row48['call_status'];
		$call_duration = $row48['call_duration'];
		$audio_url = $row48['audio_url'];
	} */
	
	/*while ($row49 = mysql_fetch_assoc($resulttsrt3140)) 
	{
		$scorer = $row49['scorer'];
		$totalResult = $row49['totalResult'];
	} */
	
	/*while ($row50 = mysql_fetch_assoc($resulttsrd4150)) 
	{
		$scorer = $row50['scorer'];
		$upload_date = $row50['upload_date'];
		$file_id = $row50['file_id'];
		$call_start_time = $row50['call_start_time'];
		$processing_start = $row50['processing_start'];
		$processing_end = $row50['processing_end'];
		$processing = $row50['processing'];
		$industry = $row50['industry'];
		$account_name = $row50['account_name'];
		$customer_name = $row50['customer_name'];
		$call_id = $row50['call_id'];
		$call_type = $row50['call_type'];
		$call_status = $row50['call_status'];
		$call_duration = $row50['call_duration'];
		$audio_url = $row50['audio_url'];
	} */
	
	/*while ($row51 = mysql_fetch_assoc($resulttsrt4150)) 
	{
		$scorer = $row51['scorer'];
		$totalResult = $row51['totalResult'];
	} */
	
	/*while ($row52 = mysql_fetch_assoc($resulttsrd5160)) 
	{
		$scorer = $row52['scorer'];
		$upload_date = $row52['upload_date'];
		$file_id = $row52['file_id'];
		$call_start_time = $row52['call_start_time'];
		$processing_start = $row52['processing_start'];
		$processing_end = $row52['processing_end'];
		$processing = $row52['processing'];
		$industry = $row52['industry'];
		$account_name = $row52['account_name'];
		$customer_name = $row52['customer_name'];
		$call_id = $row52['call_id'];
		$call_type = $row52['call_type'];
		$call_status = $row52['call_status'];
		$call_duration = $row52['call_duration'];
		$audio_url = $row52['audio_url'];
	} */
	
	/* while ($row53 = mysql_fetch_assoc($resulttsrt5160)) 
	{
		$scorer = $row53['scorer'];
		$totalResult = $row53['totalResult'];
	} */
	
	/*while ($row54 = mysql_fetch_assoc($resulttsrd61a)) 
	{
		$scorer = $row54['scorer'];
		$upload_date = $row54['upload_date'];
		$file_id = $row54['file_id'];
		$call_start_time = $row54['call_start_time'];
		$processing_start = $row54['processing_start'];
		$processing_end = $row54['processing_end'];
		$processing = $row54['processing'];
		$industry = $row54['industry'];
		$account_name = $row54['account_name'];
		$customer_name = $row54['customer_name'];
		$call_id = $row54['call_id'];
		$call_type = $row54['call_type'];
		$call_status = $row54['call_status'];
		$call_duration = $row54['call_duration'];
		$audio_url = $row54['audio_url'];
	} */
	
	/*while ($row55 = mysql_fetch_assoc($resulttsrt61a)) 
	{
		$scorer = $row55['scorer'];
		$totalResult = $row55['totalResult'];
	} */
	
	/*$total10 = mysql_fetch_assoc($resultTotalNoScoresR); 
	$scorer = $total10['scorer'];
	$total = $total10['total'];
	$total11 = mysql_fetch_assoc($resultTotalScoresR); 
	$scorer = $total11['scorer'];
	$total = $total11['total'];
	$total12 = mysql_fetch_assoc($resultAverageScoresR); 
	$scorer = $total12['scorer'];
	$total = $total12['total'];*/
	
		
	//mysql_free_result($resulttsd10b);
	//mysql_free_result($resulttst10b);
	//mysql_free_result($resulttsd1120);

?>
