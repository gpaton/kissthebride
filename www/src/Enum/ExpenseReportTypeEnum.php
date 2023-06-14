<?php

namespace App\Enum;

enum ExpenseReportTypeEnum: string
{
    case GAS = 'Essence';
    case TOLL = 'Péage';
    case MEAL = 'Repas';
    case CONFERENCE = 'Conférence';   
}