<?php
App::uses('Component', 'Controller');
class CookieComponent extends Component {
	public function getSelectionsFromCookie(){
		$sels=array();

		if(isset($_COOKIE['selectionsOnBetslip1'])){
                        $_COOKIE['selectionsOnBetslip1'] = $this->cleanCookieScape($_COOKIE['selectionsOnBetslip1']);
                        $selections=json_decode(urldecode(trim($_COOKIE['selectionsOnBetslip1'])), true);
			foreach($selections as $selection)
				array_push($sels, $selection);
		}
		if(isset($_COOKIE['selectionsOnBetslip2'])){
                        $_COOKIE['selectionsOnBetslip2'] = $this->cleanCookieScape($_COOKIE['selectionsOnBetslip2']);
			$selections=json_decode(urldecode($_COOKIE['selectionsOnBetslip2']), true);
			foreach($selections as $selection)
				array_push($sels, $selection);
		}
		if(isset($_COOKIE['selectionsOnBetslip3'])){
                         $_COOKIE['selectionsOnBetslip3'] = $this->cleanCookieScape($_COOKIE['selectionsOnBetslip3']);
			$selections=json_decode(urldecode($_COOKIE['selectionsOnBetslip3']), true);
			foreach($selections as $selection)
				array_push($sels, $selection);
		}
		return $sels;
	}
        
        /**
         * This function deletes all double quote escape done by the JMeter application.
         */
        private function cleanCookieScape($data){
            $data = str_replace('\"', '"', $data);
            if($data{0} == '"' && $data{strlen($data)-1}){
                $data{0} = '';
                $data{strlen($data)-1} = '';
            }
            return $data;
        }
}
