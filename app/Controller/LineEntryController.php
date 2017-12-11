
<?php

App::uses('AppController', 'Controller');

class LineEntryController extends AppController {

    var $layout = 'admin_layout';
    public $uses = array('Configuration');

    // public $components = array('Auth');

    public function beforeFilter() {
        // Read helper App
        $view = new View($this);
        $this->App = $view->loadHelper('App');
    }

    public function isAuthorized($user) {
        parent::isAuthorized($user);
        if ($user['accessAdmin']) {
            if ($this->App->it_has_permission('LineEntryAccess')) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get Game Lines: build lines structure html - Ajax
     *  @author vlauriou
     * @return (string) struture html lines
     */
    public function getGameLines() {

        $salida = array();

        try {
            $authUser = $this->Auth->user();
            $account = trim($authUser['customerId']);
            $sport = trim($this->request->data('sport'));
            $subSport = trim($this->request->data('subSport'));
            $schedule = trim($this->request->data('schedule'));
            $periodName = trim($this->request->data('periodName'));
            $periodNumber = trim($this->request->data('periodNumber'));
            $userStore = trim($authUser['store']);

            if (isset($account)) {
                $soapLdap = $this->getService('lineEntry');

                $result = $soapLdap->getGameLines(array("account" => $account, "sport" => $sport, "subSport" => $subSport,
                    "schedule" => $schedule, "periodName" => $periodName, "periodNumber" => $periodNumber, "userStore" => $userStore));
                $response = json_decode($result->return, true);
                $salida["L"] = $response['results'];


                $view = new View($this, false);

                $structure_lines = '';
                $structure_lines_mobile = '';
                foreach ($salida['L'] as $key => $val) {
                    $keyRow = $key;
                    $row = $val;

                    $row["GameNum"] = trim($row['GameNum']);
                    $row["Team1SpreadVolume"] = trim($row['Team1SpreadVolume']);
                    $row["Store"] = trim($row['Store']);
                    $row["Team2SpreadVolume"] = trim($row['Team2SpreadVolume']);
                    $row["PeriodNumber"] = trim($row['PeriodNumber']);
                    $row["TotalPoints"] = $this->processEncodeData(trim($row['TotalPoints']), 't');
                    $row["TtlPtsAdj1"] = trim($row['TtlPtsAdj1']);
                    $row["Team1MoneyLineVolume"] = trim($row['Team1MoneyLineVolume']);
                    $row["TtlPtsAdj2"] = trim($row['TtlPtsAdj2']);
                    $row["OverVolume"] = trim($row['OverVolume']);
                    $row["DrawMoneyLineVolume"] = trim($row['DrawMoneyLineVolume']);
                    $row["SportSubType"] = trim($row['SportSubType']);
                    $row["ListedPitcher2"] = trim($row['ListedPitcher2']);
                    $row["ListedPitcher1"] = trim($row['ListedPitcher1']);
                    $row["GameDateTime"] = trim($row['GameDateTime']);
                    $row["Team2RotNum"] = trim($row['Team2RotNum']);
                    $row["Team2ID"] = trim($row['Team2ID']);
                    $row["LinkedToStoreFlag"] = trim($row['LinkedToStoreFlag']);
                    $row["CustProfile"] = trim($row['CustProfile']);
                    $row["MoneyLine2"] = trim($row['MoneyLine2']);
                    $row["MoneyLine1"] = trim($row['MoneyLine1']);
                    $row["GameIsDownFlag"] = trim($row['GameIsDownFlag']);
                    $row["PeriodDescription"] = trim($row['PeriodDescription']);
                    $row["SportType"] = trim($row['SportType']);
                    $row["UnderVolume"] = trim($row['UnderVolume']);
                    $row["Spread1"] = $this->speadTeams($row["Spread"], $row["Team1ID"], $row["FavoredTeamID"]);
                    $row["Spread2"] = $this->speadTeams($row["Spread"], $row["Team2ID"], $row["FavoredTeamID"]);
                    $row["Spread1"] = $this->processEncodeData(trim($row['Spread1']), 's');
                    $row["Spread2"] = $this->processEncodeData(trim($row['Spread2']), 's');
                    $row["FavoredTeamID"] = trim($row['FavoredTeamID']);
                    $row["Team1RotNum"] = trim($row['Team1RotNum']);
                    $row["Status"] = trim($row['Status']);
                    $row["SpreadAdj2"] = trim($row['SpreadAdj2']);
                    $row["ScheduleText"] = trim($row['ScheduleText']);
                    $row["ScheduleDate"] = trim($row['ScheduleDate']);
                    $row["SpreadAdj1"] = trim($row['SpreadAdj1']);
                    $row["MoneyLineDraw"] = trim($row['MoneyLineDraw']);
                    $row["Team2MoneyLineVolume"] = trim($row['Team2MoneyLineVolume']);
                    $row["DrawRotNum"] = trim($row['DrawRotNum']);
                    $row["Team1ID"] = trim($row['Team1ID']);
                    $row["Team1TotalPoints"] = $this->processEncodeData(trim($row['Team1TotalPoints']), 't');
                    $row["Team2TotalPoints"] = $this->processEncodeData(trim($row['Team2TotalPoints']), 't');

                    $diffValue = array();
                    if ($row["CustProfile"] == $account) {
                        $diffValue = $this->getTheChangedValue($row["GameNum"], $row["Store"], $row["PeriodNumber"], $row["CustProfile"]);
                    }
                    $structure_lines .= $view->element('LineEntry/lines', array('account' => $account, 'key' => $keyRow, 'row' => $row, 'diffValue' => $diffValue));
                    $structure_lines_mobile .= $view->element('LineEntry/lines2', array('key' => $keyRow, 'row' => $row, 'diffValue' => $diffValue));
                }

                if ($sport == "Soccer") {
                    $nameSport = $sport . " - " . $schedule;
                } else {
                    $nameSport = $sport . " - " . $subSport;
                }
                $this->autoRender = false;
                $res = $view->element('LineEntry/wrapLineEntry', array('lines' => $structure_lines, 'games' => $structure_lines_mobile, 'name' => $nameSport));
                $this->set('content', $res);
                $this->layout = "ajax";
                $this->render('/Elements/LineEntry/default');
            }
        } catch (Exception $exc) {
            return new CakeResponse(array('body' => json_encode($exc->getMessage())));
        }
    }

    /**
     * get The Changed Value lines master and shade
     * 
     * @param {string} $gameNum     
     * @param {string} $store       
     * @param {int} $period      
     * @param {string} $custProfile 
     * 
     * @return {array} $diffValue value changed
     */
    private function getTheChangedValue($gameNum, $store, $period, $custProfile) {
        $lineShade = $this->getInfoLineCustProfil($gameNum, $store, $period, $custProfile);
        $lineMaster = $this->getInfoLineCustProfil($gameNum, $store, $period, '.');

        $diffValue = array();
        foreach ($lineShade['row1'] as $key => $val) {
            if ($lineShade['row1'][$key] != $lineMaster['row1'][$key]) {
                $diffValue[] = $key;
            }
        }
        return $diffValue;
    }

    private function getInfoLineCustProfil($gameNum, $store, $period, $custProfile) {
        $params = array("db" => Configure::read('db'),
            "gamenum" => $gameNum,
            "store" => $store,
            "periodo" => $period,
            "cusprofile" => $custProfile);
        return $this->Configuration->getInfoLineCuspro($params);
    }

    /**
     * Transforms the way sign adequate
     *  @author vlauriou
     * @param int $spead  value spread
     * @param string $team current team
     * @param sring $favorite favorite team of game
     * 
     * @return int new value spread
     */
    private function speadTeams($spead, $team, $favorite) {
        if (!empty($spead)) {
            if ($team == $favorite) {
                if ($spead <= 0) {
                    return $spead;
                } else {
                    $spead = str_replace('+', '', $spead);
                    return - $spead;
                }
            } else {
                if ($spead <= 0) {
                    return abs($spead);
                } else {
                    return $spead;
                }
            }
        }
        return $spead;
    }

    /*
     * Get Sports: build menu sports structure html - Ajax
     *  @author vlauriou
     * @return (string) struture html menu sports
     */

//    

    /*
     * Parse the name of a sport
     *  @author vlauriou
     * @param string $sport name sport
     * @return string name parced
     */
    private function iconSports($sport) {
        $sport = preg_replace('/\s{2,}/', ' ', $sport);
        $sport = preg_replace('/\s/', '_', $sport);
        $sport = preg_replace('/[\/\&%#\$]/', '_', $sport);
        $sport = preg_replace('/[\/\&.+%#\$]/', '_', $sport);
        $sport = strtolower($sport);
        return $sport;
    }

    /*
     *
     */

    private function processEncodeData($valor, $total) {
        $valor = floatval($valor);
        //
        if (!isset($valor)) {
            return '';
        }

        if ($valor === 0.0) {
            return 0;
        }

        if (is_numeric($valor)) { // if numeric
            if (floor($valor) != $valor) { // if float
                $integer = null;
                if ($valor > 0) {
                    $integer = floor($valor); // int inf
                } else {
                    $integer = ceil($valor); // int sup
                }

                $rest = abs($valor) - abs($integer); // despues del coma

                $valor_string = strval($valor);
                if ($valor > 0 && $total == 's') {
                    $valor_string = '+' . $valor_string;
                }

                $pos = strpos($valor_string, '.');
                $integer_string = substr($valor_string, 0, $pos);

                if ($total == 's') { // Spread
                    switch (abs($rest)) {
                        case 0.25:
                            if (abs($integer) == 0) {
                                if ($valor < 0) {
                                    return 'pk,-½';
                                }
                                return 'pk,+½';
                            }
                            return $integer_string . ',' . $integer_string . '½';


                            break;
                        case 0.5:
                            if (abs($integer) == 0) {
                                if ($valor < 0) {
                                    return '-½';
                                }
                                return '+½';
                            }
                            return $integer_string . '½';
                            break;
                        case 0.75:
                            if (abs($integer) == 0) {
                                if ($valor < 0) {
                                    return '-½,-1';
                                }
                                return '+½,+1';
                            } else {
                                if ($valor < 0) {
                                    return $integer_string . '½,' . strval(floor($valor));
                                }
                                return $integer_string . '½,' . strval(ceil($valor));
                            }
                            break;
                    }
                } else { // No Spread
                    if (abs($rest) == 0.5) {
                        if (abs($integer) == 0) {
                            if ($valor < 0) {
                                return '-½';
                            }
                            return '+½';
                        }
                        return $integer_string . '½';
                    }
                }
            } else { // if integer or total/ttp
                if ($valor > 0) {
                    if ($total == 's') {
                        return '+' . strval($valor);
                    }
                    return strval($valor);
                }
                return strval($valor);
            }
        }
        return '';
    }

}
