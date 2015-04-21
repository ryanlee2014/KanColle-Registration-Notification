function Convert(str)
{
	if(str == "日曜日")
	{
		return "星期日";
	}
	if(str == "月曜日")
	{
		return "星期一";
	}
	if(str == "火曜日")
	{
		return "星期二";
	}
	if(str == "水曜日")
	{
		return "星期三";
	}
	if(str == "木曜日")
	{
		return "星期四";
	}
	if(str == "金曜日")
	{
		return "星期五";
	}
	if(str == "土曜日")
	{
		return "星期六";
	}
}

function getMonthSec(month)
{
	switch(month)
	{
	case 1:
		return 0;
		break;
	case 2:
		return 31;
		break;
	case 3:
		return 31 + 28;
		break;
	case 4:
		return 31 + 28 + 31;
		break;
	case 5:
		return 31 + 28 + 31 + 30;
		break;
	case 6:
		return 31 + 28 + 31 + 30 + 31;
		break;
	case 7:
		return 31 + 28 + 31 + 30 + 31 + 30;
		break;
	case 8:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31;
		break;
	case 9:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31 + 31;
		break;
	case 10:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31 + 31 + 30;
		break;
	case 11:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31 + 31 + 30 + 31;
		break;
	case 12:
		return 31 + 28 + 31 + 30 + 31 + 30 + 31 + 31 + 30 + 31 + 30;
		break;
	}
}