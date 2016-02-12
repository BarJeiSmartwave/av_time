<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Time_model extends CI_Model
{
	public function getTimeLogs()
	{
		$dateNow = date("Y-m-d");
		$timeLogQuery = $this->db->select("logId, tbl_timelogs.userId, lastName, firstName, logDate, logIn, breakTime, logOut, lateHours, logHours")
		->from("tbl_timelogs")
		->order_by("logIn")
		->join("tbl_accounts", "tbl_timelogs.userId = tbl_accounts.userId")
		->where("logDate", $dateNow)
		->get();
		return $timeLogQuery->result();
	}

	public function timeIn($logData, $userId)
	{
		$this->db->insert("tbl_timelogs", $logData);

		$this->db->set("statusCode", 1)
		->where("userId", $userId)
		->update("tbl_accounts");
	}

	public function selectMaxLogUserLogId($userId)
	{
		$queryMax = $this->db->select_max("logId")
		->where("userId", $userId)
		->get("tbl_timelogs")->row();
		$maxLogId = $queryMax->logId;
		return $maxLogId;
	}

	public function timeOut($logData, $userId)
	{
		$maxLogId = $this->selectMaxLogUserLogId($userId);
		$this->db->set($logData)
		->where("userId", $userId)
		->where("logId", $maxLogId)
		->update("tbl_timelogs");

		$this->setUserOffline($userId);		
		$this->computeTotalHours($userId, $maxLogId);
	}

	public function setUserOnBreak($logData, $userId)
	{
		$maxLogId = $this->selectMaxLogUserLogId($userId);
		$this->db->set($logData)
		->where("userId", $userId)
		->where("logId", $maxLogId)
		->update("tbl_timelogs");

		$this->setBreakStatus($userId);
	}

	public function endBreak($userId)
	{
		$this->db->set("statusCode", 1)
		->where("userId", $userId)
		->update("tbl_accounts");
	}

	public function setUserOffline($userId)
	{
		$this->db->set("statusCode", 0)
		->where("userId", $userId)
		->update("tbl_accounts");
	}

	public function setBreakStatus($userId)
	{
		$this->db->set("statusCode", 2)
		->where("userId", $userId)
		->update("tbl_accounts");
	}

	public function computeTotalHours($userId, $maxLogId)
	{
		$getIfLate = $this->db->select()
		->from("tbl_timelogs")
		->where("userId", $userId)
		->where("logId", $maxLogId)
		->get();

		$results = $getIfLate->row();

		// $dateTimeNow = date("Y-m-d H:i:s");
		$timeCap = strtotime("18:00:00");
		$timeFormat = date("H:i:s");
		$timeNow = strtotime($timeFormat);

		
		if($results->lateHours == "00:00:00" && $timeNow < $timeCap) // not late, early out (nagana)
		{
			$timeDiffData = "TIMEDIFF(logOut, CONCAT(DATE(logIn),' 09:00:00')) as totalHours";

			$timeDiffQuery = $this->db->select($timeDiffData)
			->from("tbl_timelogs")
			->where("userId", $userId)
			->where("logId", $maxLogId)
			->get();

			$logHours = $timeDiffQuery->row();
			$this->updateTotalHours($userId, $logHours, $maxLogId);
		}
		elseif($timeNow < $timeCap ) // late, early out (nagana)
		{
			$timeDiffData = "TIMEDIFF(logOut, login) as totalHours";

			$timeDiffQuery = $this->db->select($timeDiffData)
			->from("tbl_timelogs")
			->where("userId", $userId)
			->where("logId", $maxLogId)
			->get();

			$logHours = $timeDiffQuery->row();
			$this->updateTotalHours($userId, $logHours, $maxLogId);
		}
		elseif($results->lateHours == "00:00:00") // not late, exact time out (nagana)
		{
			$timeDiffData = "TIMEDIFF(CONCAT(DATE(logOut),' 18:00:00'), CONCAT(DATE(logIn),' 09:00:00')) as totalHours";

			$timeDiffQuery = $this->db->select($timeDiffData)
			->from("tbl_timelogs")
			->where("userId", $userId)
			->where("logId", $maxLogId)
			->get();

			$logHours = $timeDiffQuery->row();
			$this->updateTotalHours($userId, $logHours, $maxLogId);
		}
		else // late, exact time out (nagana na)
		{
			$timeDiffData = "TIMEDIFF(CONCAT(DATE(logOut),' 18:00:00'), login) as totalHours";

			$timeDiffQuery = $this->db->select($timeDiffData)
			->from("tbl_timelogs")
			->where("userId", $userId)
			->where("logId", $maxLogId)
			->get();

			$logHours = $timeDiffQuery->row();
			$this->updateTotalHours($userId, $logHours, $maxLogId);	
		}
	}

	public function updateTotalHours($userId, $logHours, $maxLogId)
	{
		$totalHours = $logHours->totalHours;
		$this->db->set("logHours", $totalHours)
		->where("userId", $userId)
		->where("logId", $maxLogId)

		->update("tbl_timelogs");

		$this->computeLogHours($userId);
	}

	public function getTimeLogsById($userId)
	{
		$timeLogQuery = $this->db->select()
		->order_by("logDate")
		->from("tbl_timelogs")
		->where("userId", $userId)
		->get();

		$results = $timeLogQuery->result();
		return $results;
	}

	public function computeLogHours($userId)
	{
		$getSum = "SEC_TO_TIME(SUM(TIME_TO_SEC(logHours))) AS totalHours";
		$logHours = $this->db->select($getSum)
		->from("tbl_timelogs")
		->where("userId", $userId)
		->get();

		$totalHours = $logHours->row();
		$this->insertTotalHours($totalHours, $userId);
	}

	public function insertTotalHours($totalHours, $userId)
	{
		$this->db->set("totalHours", $totalHours->totalHours)
		->where("userId", $userId)
		->update("tbl_accounts");
	}

	public function getTimeLogsOnCurrentMonth($userId)
	{
		$dateNow = date("Y-m-d");
		$monthPeriod = date("m", strtotime($dateNow));
		$yearPeriod = date("Y", strtotime($dateNow));

		if($dateNow <= date("Y-m-15"))
		{
			$results = $this->db->select()
			->from("tbl_timelogs")
			->order_by("logDate")
			->where("extract(year FROM logDate) =".$yearPeriod)
			->where("extract(month FROM logDate) =".$monthPeriod)
			->where("extract(day FROM logDate) <= 15")
			->where("userId", $userId)
			->get();

			return $results->result();
		}
		elseif($dateNow >= date("Y-m-16"))
		{
			$results = $this->db->select()
			->from("tbl_timelogs")
			->order_by("logDate")
			->where("extract(year FROM logDate) =".$yearPeriod)
			->where("extract(month FROM logDate) =".$monthPeriod)
			->where("extract(day FROM logDate) >= 16")
			// ->where("extract(day FROM logDate) <= 30")
			->where("userId", $userId)
			->get();

			return $results->result();
		}	
	}

	public function getTotalHoursCurrentMonth($userId)
	{
		$dateNow = date("Y-m-d");
		$monthPeriod = date("m", strtotime($dateNow));
		$yearPeriod = date("Y", strtotime($dateNow));

		if($dateNow <= date("Y-m-15"))
		{
			$queryTime = "SEC_TO_TIME(SUM(TIME_TO_SEC(logHours))) AS totalHoursPeriod, SEC_TO_TIME(SUM(TIME_TO_SEC(lateHours))) AS totalLateHours";
			$results = $this->db->select("$queryTime")
			->from("tbl_timelogs")
			->where("extract(year FROM logDate) =".$yearPeriod)
			->where("extract(month FROM logDate) =".$monthPeriod)
			->where("extract(day FROM logDate) <= 15")
			->where("userId", $userId)
			->get();

			// die("<pre>".print_r($results->result()));
			return $results->result();
		}
		elseif($dateNow >= date("Y-m-16"))
		{
			$queryTime = "SEC_TO_TIME(SUM(TIME_TO_SEC(logHours))) AS totalHoursPeriod, SEC_TO_TIME(SUM(TIME_TO_SEC(lateHours))) AS totalLateHours";
			$results = $this->db->select("$queryTime")
			->from("tbl_timelogs")
			->where("extract(year FROM logDate) =".$yearPeriod)
			->where("extract(month FROM logDate) =".$monthPeriod)
			->where("extract(day FROM logDate) >= 16")
			// ->where("extract(day FROM logDate) <= 30")
			->where("userId", $userId)
			->get();

			return $results->result();
		}
	}

	public function getDatePeriods($userId)
	{
		$queryTime = "CONCAT( DATE_FORMAT(logDate, '%Y-%m-' ), CASE WHEN DAYOFMONTH( logDate ) < 15 THEN '01' ELSE CONCAT( '16'  )end ) as monthYear";
		$results = $this->db->select($queryTime)
		->from("tbl_timelogs")
		->group_by("monthYear")
		->order_by("year(logIn), month(logIn), min( dayofmonth(logIn))")
		->where("userId", $userId)
		->get();

		return $results->result();
	}

	public function viewLogsPerPeriod($userId, $datePeriod)
	{
		$monthPeriod = date("m", strtotime($datePeriod));
		$yearPeriod = date("Y", strtotime($datePeriod));

		if($datePeriod <= date("Y-m-15"))
		{
			$results = $this->db->select()
			->from("tbl_timelogs")
			->order_by("logDate")
			->where("userId", $userId)
			->where("extract(year FROM logDate) =".$yearPeriod)
			->where("extract(month FROM logDate) =".$monthPeriod)
			->where("extract(day FROM logDate) <= 15")
			->get();

			return $results->result();
		}
		elseif($datePeriod >= date("Y-m-16"))
		{
			$results = $this->db->select()
			->from("tbl_timelogs")
			->order_by("logDate")
			->where("userId", $userId)
			->where("extract(year FROM logDate) =".$yearPeriod)
			->where("extract(month FROM logDate) =".$monthPeriod)
			->where("extract(day FROM logDate) >= 16")	
			// ->where("extract(day FROM logDate) <= 30")
			->get();

			return $results->result();
		}
	}

	public function getTotalHoursPerPeriod($userId, $datePeriod)
	{
		$monthPeriod = date("m", strtotime($datePeriod));
		$yearPeriod = date("Y", strtotime($datePeriod));

		if($datePeriod <= date("Y-m-15"))
		{
			$queryTime = "SEC_TO_TIME(SUM(TIME_TO_SEC(logHours))) AS totalHoursPeriod, SEC_TO_TIME(SUM(TIME_TO_SEC(lateHours))) AS totalLateHours";
			$results = $this->db->select($queryTime)
			->from("tbl_timelogs")
			->where("extract(year FROM logDate) =".$yearPeriod)
			->where("extract(month FROM logDate) =".$monthPeriod)
			->where("extract(day FROM logDate) <= 15")
			->where("userId", $userId)
			->get();

			return $results->result();
		}
		elseif($datePeriod >= date("Y-m-16"))
		{
			$queryTime = "SEC_TO_TIME(SUM(TIME_TO_SEC(logHours))) AS totalHoursPeriod, SEC_TO_TIME(SUM(TIME_TO_SEC(lateHours))) AS totalLateHours";
			$results = $this->db->select($queryTime)
			->from("tbl_timelogs")
			->where("extract(year FROM logDate) =".$yearPeriod)
			->where("extract(month FROM logDate) =".$monthPeriod)
			->where("extract(day FROM logDate) >= 16")
			// ->where("extract(day FROM logDate) <= 30")
			->where("userId", $userId)
			->get();

			return $results->result();
		}
	}
}