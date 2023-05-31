<?php 
    namespace Services;

    class TimesheetService  {

        public function formatPerUserTemplate($timesheets, $timesheetDatePeriod = []) {
            //group per user
            //check if timesheet is late then plusOneLate
            //check if absent then absent

            $retVal = [];
            foreach($timesheets as $key => $row) {
                if(!isset($retVal[$row->user_id])) {

                    $retVal[$row->user_id] = [
                        'user' => [
                            'full_name' => $row->full_name,
                            'position_name' => $row->position_name,
                            'department_name' => $row->department_name,
                            'id' => $row->user_id
                        ],
                        'timesheets' => [],
                        'absent' => 0,
                        'present' => 0,
                        'late' => 0,
                        'remarks' => ''
                    ];
                }
                $timeIn = $row->time_in;
                $timeInDate = date('Y-m-d', strtotime($timeIn));
                
                $retVal[$row->user_id]['timesheets'][$timeInDate][] = $timeIn;
            }
            $startDateIncreasing = $timesheetDatePeriod['start_date'];
            while($startDateIncreasing <= $timesheetDatePeriod['end_date']) {
                //loop by user
                foreach($retVal as $key => $row) {
                    $userTimeSheets = $row['timesheets'];

                    if(empty($userTimeSheets)) {
                        $retVal[$key]['remarks'] = 'No Timesheet';
                        continue;
                    }

                    //count absent and present
                    $timesheetDates = array_keys($row['timesheets']);
                    //if attendend on this day then present
                    if(isEqual($startDateIncreasing, $timesheetDates)) {
                        $retVal[$key]['present']++;
                    } else {
                        $retVal[$key]['absent']++;
                    }
                    continue;
                }
                $startDateIncreasing = date('Y-m-d', strtotime('+1 day'.$startDateIncreasing));
            }
            return $retVal;
        }
    }