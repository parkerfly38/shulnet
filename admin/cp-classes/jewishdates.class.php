<?php

class jewishdates extends db
{
    function isLeapYear($year)
    {
        if ($year % 19 == 0 || $year % 19 == 3 || $year % 19 == 6 || $year % 19 == 8 || $year % 19 == 11 || $year % 19 == 14 || $year % 19 == 17)
        {
            return true;
        }
        else {
            return false;
        }
    }

    function getJewishMonthName($jewishMonth, $jewishYear) {
        $jewishMonthNamesLeap = array("Tishri", "Heshvan", "Kislev", "Tevet",
                                      "Shevat", "Adar I", "Adar II", "Nisan",
                                      "Iyar", "Sivan", "Tammuz", "Av", "Elul");
        $jewishMonthNamesNonLeap = array("Tishri", "Heshvan", "Kislev", "Tevet",
                                         "Shevat", "Adar", "Adar", "Nisan",
                                         "Iyar", "Sivan", "Tammuz", "Av", "Elul");
        if ($this->isLeapYear($jewishYear))
        {
          return $jewishMonthNamesLeap[$jewishMonth-1];
        }
        else
        {
          return $jewishMonthNamesNonLeap[$jewishMonth-1];
        }
    }

    function JewishToGregorian($day, $month)
    {
        $year = $this->getCurrentJewishYear(time());
        $month = $this->getJewishMonthNumber($month, $year);
        $jddate = jewishtojd($month, $day, $year);
        return jdtogregorian($jddate);
    }

    function getJewishMonthNumber($jewishMonth, $jewishYear)
    {
        if ($this->isLeapYear($jewishYear))
        {
          switch ($jewishMonth)
          {
            case "Tishri":
                return 1;
                break;
            case "Heshvan":
                return 2;
                break;
            case "Kislev":
                return 3;
                break;
            case "Tevet":
                return 4;
                break;
            case "Shevat":
                return 5;
                break;
            case "Adar I":
                return 6;
                break;
            case "Adar II":
                return 7;
                break;
            case "Nisan":
                return 8;
                break;
            case "Iyar":
                return 9;
                break;
            case "Sivan":
                return 10;
                break;
            case "Tammuz":
                return 11;
                break;
            case "Av":
                return 12;
                break;
            case "Elul":
                return 13;
                break;        
          }
        }
        else
        {
            switch ($jewishMonth)
            {
              case "Tishri":
                  return 1;
                  break;
              case "Heshvan":
                  return 2;
                  break;
              case "Kislev":
                  return 3;
                  break;
              case "Tevet":
                  return 4;
                  break;
              case "Shevat":
                  return 5;
                  break;
              case "Adar":
                  return 6;
                  break;
              case "Adar":
                  return 7;
                  break;
              case "Nisan":
                  return 8;
                  break;
              case "Iyar":
                  return 9;
                  break;
              case "Sivan":
                  return 10;
                  break;
              case "Tammuz":
                  return 11;
                  break;
              case "Av":
                  return 12;
                  break;
              case "Elul":
                  return 13;
                  break;        
            }
        }
    }

    function getHebrewFromGregorian($date)
    {
        $julianDate = gregoriantojd(date("n",$date), date("j", $date), date("Y",$date));
        $jewishDate = mb_convert_encoding(jdtojewish($julianDate, true), "UTF-8", "ISO-8859-8");
        $jewishDateNotHebrew= jdtojewish($julianDate);
        list($jewishMonth, $jewishDay, $jewishYear) = explode('/', $jewishDateNotHebrew);
        $jewishDateinEnglish = $jewishDay. " " . $this->getJewishMonthName($jewishMonth, $jewishYear) . " " . $jewishYear;
        $arrJewish = array("English Date"=>date("F j, Y, g:i a",$date),"Hebrew Date"=>$jewishDate,"Hebrew Date English"=>$jewishDateinEnglish);
        return $arrJewish;
    }

    function getCurrentMonth($date)
    {
        $julianDate = gregoriantojd(date("n",$date), date("j", $date), date("Y",$date));
        $jewishDate = mb_convert_encoding(jdtojewish($julianDate, true), "UTF-8", "ISO-8859-8");
        $jewishDateNotHebrew= jdtojewish($julianDate);
        list($jewishMonth, $jewishDay, $jewishYear) = explode('/', $jewishDateNotHebrew);
        //$jewishDateinEnglish = $jewishDay. " " . $this->getJewishMonthName($jewishMonth, $jewishYear) . " " . $jewishYear;
        return $this->getJewishMonthName($jewishMonth, $jewishYear);
    }

    function getCurrentJewishYear($date)
    {
        $julianDate = gregoriantojd(date("n",$date), date("j", $date), date("Y",$date));
        $jewishDate = mb_convert_encoding(jdtojewish($julianDate, true), "UTF-8", "ISO-8859-8");
        $jewishDateNotHebrew= jdtojewish($julianDate);
        list($jewishMonth, $jewishDay, $jewishYear) = explode('/', $jewishDateNotHebrew);
        //$jewishDateinEnglish = $jewishDay. " " . $this->getJewishMonthName($jewishMonth, $jewishYear) . " " . $jewishYear;
        return $jewishYear;
    }
}