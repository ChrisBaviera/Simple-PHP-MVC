<?php

namespace Application\Helpers;

class LogManager {

    private static Array $logList = [];

    public static function add(String $tag, String $msg) {

        self::$logList[] = array("TAG" => $tag, "MESSAGE" => $msg);
    }

    public static function getLogs() {

        return self::$logList;
    }

    public static function printLogs() {

        echo "<div style=' position: fixed; 
               bottom: 3px; 
               right: 4px; 
               height: 200px; 
               width: 99%; 
               border: 3px solid #c00; 
               background-color: orange;
              '>";
        echo "<div style='clear: both; display: table; font-family: Consolas,monospace; font-size: 12px; width: 100%; border-bottom: 1px solid #c00; margin-bottom: 3px;'>";
        echo "  <div style='float: left;min-width: 15%;'>TAG</div>";
        echo "  <div style='float: left;max-width: 85%;'>MESSAGE</div>
              </div><div style='overflow-y: auto; width: 100%; height: 180px; ' id='DebugBox'>";

        foreach(self::getLogs() as $log) {

            echo "<div style='clear: both; display: table; font-family: Consolas,monospace; font-size: 12px; width: 100%'>";
            echo "  <div style='float: left;min-width: 15%; font-weight: bold;'>" . $log["TAG"] . "</div>";
            echo "  <div style='float: left;max-width: 85%;'>" . $log["MESSAGE"] . "</div>
                  </div>";

        }
        

        echo "</div></div>

              <script>
                var objDiv = document.getElementById('DebugBox');
                objDiv.scrollTop = objDiv.scrollHeight;
              </script>
             ";
    }
}