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
                                         "Shevat", "", "Adar", "Nisan",
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
}