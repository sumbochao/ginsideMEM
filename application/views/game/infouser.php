<style>
.textinput
{
	width: 300px;
	border:1px solid #c5c5c5;
	padding:6px 7px;
	color:#323232;
	margin:0;
        margin-bottom: 10px;	
	background-color:#ffffff;
	outline:none;
	
	/* CSS 3 */
	
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	-o-border-radius:4px;
	-khtml-border-radius:4px;
	border-radius:4px;
	
	box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	-khtml-box-sizing: border-box;
	
	-moz-box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);
	-o-box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);	
	-webkit-box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);
	-khtml-box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);
	box-shadow:inset 0px 1px 3px rgba(128, 128, 128, 0.1);
}
input:focus.textinput
{
  box-shadow:0 0 10px #cdec96;
  background-color:#d6f8ff;
  color:#6d7e81;
}
label{
    color: #f36926;
}

.game-button{
	border:0;
	outline:none;
	padding:6px 9px;
	margin:2px;
	cursor:pointer;
	font-family:'PTSansRegular', Arial, Helvetica, sans-serif;
	/* CSS 3 */
	-webkit-border-radius:3px;
	-moz-border-radius:3px!important;
	-o-border-radius:3px;
	-khtml-border-radius:3px;
	border-radius:3px;
	
	text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4);
	
	color:#fff;
	text-shadow:0 -1px 1px rgba(0,0,0,.25);
	background-color:#019ad2;
	background-repeat:repeat-x;
	background-image:-moz-linear-gradient(#33bcef,#019ad2);
	background-image:-ms-linear-gradient(#33bcef,#019ad2);
	background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#33bcef),color-stop(100%,#019ad2));
	background-image:-webkit-linear-gradient(#33bcef,#019ad2);
	background-image:-o-linear-gradient(#33bcef,#019ad2);
	background-image:linear-gradient(#33bcef,#019ad2);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef',endColorstr='#019ad2',GradientType=0);
	border-color:#057ed0;
	-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
	box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
}
.game-button:hover{
	border:0;
	outline:none;
	padding:6px 9px;
	margin:2px;
	cursor:pointer;
	font-family:'PTSansRegular', Arial, Helvetica, sans-serif;
	/* CSS 3 */
	-webkit-border-radius:3px;
	-moz-border-radius:3px!important;
	-o-border-radius:3px;
	-khtml-border-radius:3px;
	border-radius:3px;
	
	text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4);
	
	color:#fff;
	text-shadow:0 -1px 1px rgba(0,0,0,.25);
	background-color:#019ad2;
	background-repeat:repeat-x;
	background-image:-moz-linear-gradient(#019ad2,#33bcef);
	background-image:-ms-linear-gradient(#019ad2,#33bcef);
	background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#33bcef),color-stop(100%,#019ad2));
	background-image:-webkit-linear-gradient(#019ad2,#33bcef);
	background-image:-o-linear-gradient(#019ad2,#33bcef);
	background-image:linear-gradient(#019ad2,#33bcef);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef',endColorstr='#019ad2',GradientType=0);
	border-color:#057ed0;
	-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
	box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
}

.game-button-cancel{
	border:0;
	outline:none;
	padding:6px 9px;
	margin:2px;
	cursor:pointer;
	font-family:'PTSansRegular', Arial, Helvetica, sans-serif;
	/* CSS 3 */
	-webkit-border-radius:3px;
	-moz-border-radius:3px!important;
	-o-border-radius:3px;
	-khtml-border-radius:3px;
	border-radius:3px;
	
	text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4);
	
	color:#fff;
	text-shadow:0 -1px 1px rgba(0,0,0,.25);
	background-color:#019ad2;
	background-repeat:repeat-x;
	background-image:-moz-linear-gradient(#555555,#000000);
	background-image:-ms-linear-gradient(#555555,#000000);
	background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#555555),color-stop(100%,#000000));
	background-image:-webkit-linear-gradient(#555555,#000000);
	background-image:-o-linear-gradient(#555555,#000000);
	background-image:linear-gradient(#555555,#000000);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#555555',endColorstr='#000000',GradientType=0);
	border-color:#057ed0;
	-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
	box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
}

.game-button-cancel:hover{
	border:0;
	outline:none;
	padding:6px 9px;
	margin:2px;
	cursor:pointer;
	font-family:'PTSansRegular', Arial, Helvetica, sans-serif;
	/* CSS 3 */
	-webkit-border-radius:3px;
	-moz-border-radius:3px!important;
	-o-border-radius:3px;
	-khtml-border-radius:3px;
	border-radius:3px;
	
	text-shadow:1px 1px 1px rgba(0, 0, 0, 0.4);
	
	color:#fff;
	text-shadow:0 -1px 1px rgba(0,0,0,.25);
	background-color:#019ad2;
	background-repeat:repeat-x;
	background-image:-moz-linear-gradient(#000000,#555555);
	background-image:-ms-linear-gradient(#000000,#555555);
	background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#000000),color-stop(100%,#555555));
	background-image:-webkit-linear-gradient(#000000,#555555);
	background-image:-o-linear-gradient(#000000,#555555);
	background-image:linear-gradient(#000000,#555555);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bcef',endColorstr='#019ad2',GradientType=0);
	border-color:#057ed0;
	-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
	box-shadow:inset 0 1px 0 rgba(255,255,255,.1);
}



ul.error{
	padding: 5px;
	background: #f36926;
	margin-bottom: 30px;
}
ul.error li{
	margin-left: 20px;
	color:#eee;
}


.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  /*background-color: #dff0d8;*/
  background-color: #b0bed9;
 }


#content-t table tbody tr:nth-child(even){
    background: #eee;
}
#content-t table tbody tr:nth-child(odd){
    background: #fff;
}

.tool-head{
    background-color: #D1D119!important;
    padding:5px;
    font-weight: bold;
    color:#f3631e;
    text-transform:uppercase;
}
table tbody tr td.selected {
  background-color: #b0bed9!important;
}
</style>

<div id="content-t" style="min-height:500px; padding-top:10px">
<?php
    //echo time();
    $t = (time() - 86400*7).'999';
    //$t = time()*1000000000000;
    //$t = time().'999';
    //$t = 1397371290461;
    //echo date('Y-m-d H:i:s',1397731263);
    //echo $t;
    //echo date('Y-m-d H:i:s',1397390438);
    //echo base64_decode('Q2jDumMgbeG7q25nIHF14buRYyBnaWEgY+G7p2EgYuG6oW4gxJHDoyDEkeG6oXQgZ2nhuqNpIG5o4bqldCB0cm9uZyBUw61jaCDEkGnhu4NtIFRoacOqbiBI4bqhIGzhuqduIHRyxrDhu5tjLCBuaOG6rW4gxJHGsOG7o2NC4bqhYzEwMDAwMDA=');
    //echo '<br>'.base64_decode('YWxvaGE=');
    //echo '<br>'.base64_decode('RE0gR00=');
    //echo '<br>'.  base64_decode('xJDhu4tjaE5nxrDhu51pIGNoxqFpIG7GsOG7m2NbQmFuaEJhb10gxJHhu5FpIHbhu5tpIGLhuqFuQ2hpbmggcGjhuqF077yMxJHDoW5oIGLhuqFpIGLhuqFuLCBjxrDhu5twIMSRaTEwMDk4MELhuqFjLCBt4bqldDY2xJFp4buDbSB1eSBkYW5oLltYZW0gQ2hp4bq/biBiw6FvXVtQaOG6o24ga8OtY2hd');
    //$j = '{"lastAddGoldTime":0,"pvpWinTimes":4,"giveHeroChargeLastTime":0,"isCanDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAAAAAAA=","canDrawPveWholePrize":false,"slaveNum":2,"pLuoYangRewards":"com.xingcloud.service.item.OwnedItemCollection:c2caccf7-d2ef-4e86-970e-27f65c998971","isCanDrawChargePrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAQEBAQA=","collectFreeSoldierTimes":0,"heroStatuMark":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAEB","attrMaxCoin":2100000,"towerMaxLevel":3,"registerTime":1397380014412,"goodsProductionCD":1397476423823,"heroRealizationGoldTimes":0,"pLuoYangRecords":"com.xingcloud.service.item.OwnedItemCollection:c4b716ab-d760-4d96-b793-7caef3e058d4","pBattlePVPs":"com.xingcloud.service.item.OwnedItemCollection:430331f1-4c02-4aa2-b378-a26f5326c501","username":"534a539ce4b0bedabdc174d8_5","taxesdTimes":0,"enhancedLocked":false,"salary":31000,"goodsProductionLocked":false,"lastChargeTime":1397389937161,"allianceTaxesdDonateCoin":0,"channelId":"NaverNeo","isDef":false,"lordName":"","activeNum":0,"peopleMax":0,"cropTradingLimit":60000,"lastCollectFreeSoldierTime":1397408261579,"lastAddActionPowerTime":0,"isFinishSign":false,"heroNum":6,"isCompleteFirstCharge":false,"userStatus":"rO0ABXNyACVjb20ueGluZ2Nsb3VkLnNlcnZpY2UudXNlci5Vc2VyU3RhdHVzAAAAAAAAAAECAAhaAAxmcmVlemVTdGF0dXNaAApraWNrU3RhdHVzWgAMb25saW5lU3RhdHVzTAANZnJlZXplRW5kVGltZXQAE0xqYXZhL2xhbmcvSW50ZWdlcjtMAA9mcmVlemVTdGFydFRpbWVxAH4AAUwAC2xhc3RMb2dpbklQdAASTGphdmEvbGFuZy9TdHJpbmc7TAANbGFzdExvZ2luVGltZXEAfgABTAAObGFzdExvZ291dFRpbWVxAH4AAXhyADpjb20ueGluZ2Nsb3VkLmZyYW1ld29yay5vcm0uZGFvLmFjdGl2ZV9yZWNvcmQuQWN0aXZlUmVjb3JkAAAAAAAAAAECAAFMAAljbGFzc05hbWVxAH4AAnhwdAAKVXNlclN0YXR1cwAAAHNyABFqYXZhLmxhbmcuSW50ZWdlchLioKT3gYc4AgABSQAFdmFsdWV4cgAQamF2YS5sYW5nLk51bWJlcoaslR0LlOCLAgAAeHAAAAAAcQB+AAh0AA0xMTguNjguNDQuMTI4c3EAfgAGU0v1EnEAfgAI","isCanDrawFirstChargePrize":false,"allianceGreadDonateCoin":0,"mineSeizeNum":0,"tradeTimes":0,"loginDays":2,"token":50,"pvpWinning":1.0,"continueDays":0,"heroRecruitPurpleTimer":812,"searchEquipLocked":false,"gold":33118,"fightNoticeTimes":0,"lastLoginTime":1.397486866135E12,"enhancedRate":0.86,"isCanDrawBigChargePrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAAAAAAA=","attackAddition":0.0,"pFormations":"com.xingcloud.service.item.OwnedItemCollection:f97cfd94-579f-4ea7-b331-d416d2ce8a51","pvpLoss":0,"randomIslandTime":0,"taxationGold":0,"attrPointElectTimes":1,"battleTimes":168,"lastPVPAtketedTime":0,"questionTime":0,"isCanDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAQAAAA==","heroFastTrainExploitsExpend":250,"heroRecruitTimer":607,"finishTask":false,"troopIndex":-1,"gainTimes":0,"lastGainTime":1397401329113,"rebuiltFreeTimes":1,"pSendMails":"com.xingcloud.service.item.OwnedItemCollection:23c65252-77a9-4b4d-99ff-a83ef1685397","luoyangRewardCDTime":1397491200245,"crop":925516,"mainTaskFinishList":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAPAQEBAAEBAAAAAAAAAAAA","description":"","onlinePrizeFinish":false,"gender":true,"pBattleTowers":"com.xingcloud.service.item.OwnedItemCollection:cacb2581-2f55-415f-90c9-ee4f44a52e1e","towerLocked":true,"pBoxs":"com.xingcloud.service.item.OwnedItemCollection:7cf4200c-8cda-4066-821f-d42fe53e1e01","pVitalitys":"com.xingcloud.service.item.OwnedItemCollection:80e95637-04d4-4870-8212-9c9c2b158523","islandProsperity":0,"lastAwardNationalReward":1397420100005,"fightNoticeItem":0,"luoyangLocked":false,"country":0,"leaveAllianceTime":1397411843672,"relieveCropNeed":230,"pveWholeLastTime":0,"sessionId":"ad2b401c16c0405c8ae1366e48325c96","heartbeat":23291356,"isHasDrawFirstChargePrize":true,"pveWholeTimes":0,"dailyPrizeTime":0,"taxation":20506,"taxesdMaxTimes":16,"t6vars":"rO0ABXVyAAJbSU26YCZ26rKlAgAAeHAAAACWAAAAJgAAABcAAAAmAAAAAQAAAAEAAAABAAAAAgAAADIAAAABAAAAAgAAAAIAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA","everyDayOnlinePrizeLevel":1,"recruitTalkCDTime":1397401886505,"buildingMaxLevel":115,"fightMsgNum":0,"heartbeatLastTime":0,"isBattleLocked":false,"fastTrainLocked":false,"luoyangTop":1,"business":1,"luoyangCDTime":1397401659895,"pMessages":"com.xingcloud.service.item.OwnedItemCollection:dd3a7783-b7e9-4ab5-a41a-d9ab36695764","lastAddPeopleTime":0,"onlinePrizeLevel":4,"name":"BanhBao","attrMaxCrop":260000,"className":"UserProfile","experience":0,"enhancedCDTime":1397472743656,"coupon":0,"gainCropCD":1397401449113,"pTasks":"com.xingcloud.service.item.OwnedItemCollection:a2293acf-e2d2-4cd2-8b07-973299c66831","icon":0,"pHeros":"com.xingcloud.service.item.OwnedItemCollection:6c6a66c4-e530-4211-ba8b-b32efdb76a90","isOutOrAddAlliance":false,"fightSeizeItem":0,"pkValue":13,"luoyangRewardLocked":true,"goldMax":0,"lastActiveTime":1397486878943,"searchEquipCd":1397479011427,"lastSetEquipEnhancedProTime":1397486871883,"pvpTimes":0,"heroSecondTransfer":0,"forceCoinTimes":0,"buildingFreeQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAACAAA=","exRinking":0,"soldierMax":130000,"remainsTaxesCD":0,"isHistoryGuidOver":false,"attrMaxGainTimes":6,"allianceWaterConDonateCoin":0,"guidePHeroUid":"046ed5c0-8d96-4251-814c-d36e04d85b65","lastChatTime":1397390756914,"lastAddTokenTime":1397479241582,"pveTimes":0,"platformValidate":0,"people":210,"punishmentTime":0,"isHasDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAQEAAAA=","actionPower":0,"pBuildings":"com.xingcloud.service.item.OwnedItemCollection:3b6a495e-ea9c-4ebe-8155-d487161b9a28","onlinePrizeTime":1397411087083,"waterCon":0,"addTrainSizeNeedGold":150,"tradeFinishTime":0,"exploits":505968,"silverMineNum":1,"pAlliances":"com.xingcloud.service.item.OwnedItemCollection:3f65d742-98b1-4eaf-9a15-3ffbb3ca91df","pSlaves":"com.xingcloud.service.item.OwnedItemCollection:9b0cf538-a44e-4382-9e0e-c74540bcf8fc","fatCropTimes":0,"vitality":40,"pveLastTime":0,"canDrawPvpPrize":false,"isUserPause":false,"canGivePurpleHero":false,"soldier":0,"towerChallengeId":"Tower-2","exRanking":0,"canDrawMainTaskPrize":true,"buildingFreeQueues":"rO0ABXVyAAJbSnggBLUSsXWTAgAAeHAAAAACAAABRWBQuvUAAAFFYHlIlQ==","pFriends":"com.xingcloud.service.item.OwnedItemCollection:fecad3fd-1e6e-4969-bc55-a41649fa6053","giveHeroChargeSum":0,"islandLevel":0,"forceProductionTimes":11,"isHasDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAAAAAA==","heroFastTrainCD":1397406928581,"everyDayOnlinePrizeTime":1397466725097,"alliancePrestigeDonateCoin":0,"troopChallenge":"Troop-1001","luoyangTimes":15,"money":0,"smelt":0,"pPVPRecords":"com.xingcloud.service.item.OwnedItemCollection:29cc190a-17c1-4ae1-ab50-1da364ae5038","lastTaxesdTime":0,"heroFirstTransfer":0,"rmbAmount":5000,"defenseAddition":0.0,"purpleCrystalNum":21,"pEquips":"com.xingcloud.service.item.OwnedItemCollection:f231caf9-a8f5-40cf-9883-93fafe408181","buildingPayedQueuesNeedGold":50,"heroRealizationTimes":0,"remainsTaxesLocked":false,"pBattlePVEs":"com.xingcloud.service.item.OwnedItemCollection:1a985db6-c9a6-4305-a378-bd881ab75891","sqq":0,"battleCD":1397409516436,"eventPeopleLocked":false,"isHasGainSalary":false,"historyIslandLevel":0,"heroRealizationTenGold":4,"lastAtkedTime":1397459922570,"isOldPlayer":false,"eventPeopleCDTime":1397401662362,"taxes":0,"isPVPAtked":false,"uid":"e1768f8b-a1c4-4376-b999-ba93db8967da","fightSeizeTimes":0,"pointElectTime":1397403067464,"troopActiveHeros":"rO0ABXVyABNbTGphdmEubGFuZy5TdHJpbmc7rdJW5+kde0cCAAB4cAAAADN0AAhIZXJvLTI3N3QACEhlcm8tMjc2dAAHSGVyby0xMHQAB0hlcm8tMTF0AAhIZXJvLTI3OHQACEhlcm8tMjc5dAAHSGVyby0xMnQAB0hlcm8tMTN0AAhIZXJvLTI4MHQAB0hlcm8tMTh0AAdIZXJvLTIwdAAHSGVyby05MHQAB0hlcm8tOTF0AAdIZXJvLTI1dAAISGVyby0yODN0AAhIZXJvLTI4NXQACEhlcm8tMjg0cHBwcHBwcHBwcHBwdAAHSGVyby0yOHQACEhlcm8tMjg3dAAHSGVyby0yOXQAB0hlcm8tMzB0AAhIZXJvLTI4OXQAB0hlcm8tMzF0AAdIZXJvLTMydAAHSGVyby0zNXBwcHBwdAAHSGVyby0zNnQACEhlcm8tMjkwdAAISGVyby0yOTN0AAdIZXJvLTQwdAAISGVyby0yOTR0AAhIZXJvLTI5NXQAB0hlcm8tNDFwcA==","recruitTalkLocked":false,"fightSeizeTime":0,"allianceExploitsDonateCoin":100000,"mineNumNow":0,"level":60,"lastLastLoginTime":1397466998373,"protecedTime":1397392015282,"towerCD":1397489074853,"pGoodss":"com.xingcloud.service.item.OwnedItemCollection:5b9f0a94-f563-43b2-8bfd-88e2ad03de32","power":0,"mailCheck":false,"heroRealizationGold":2,"pvpEnemyWinTimes":3,"isHasDrawBigChargePrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAAAAAAA=","status":0,"pChats":"com.xingcloud.service.item.OwnedItemCollection:960b699e-255c-49b2-85e4-af896c059643","chargeGoldSum":50000,"pvpLastTime":0,"orangeCrystalNum":0,"heroFirstAdvanced":50,"msgCheck":false,"exp":0,"canGiveYellowHero":false,"cropTradingNum":0,"everyDayChargeSum":50000,"heroTrainQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAQEAAAA=","everyDayOnlinePrizeFinish":false,"heroFastTrainExp":25000,"popular":100,"forceCoinUseGold":2,"titleId":"Title-6","loginPrizeTimes":0,"mainTaskId":"MainTask-26","collectFreeSoldierNum":3000,"canDrawSuperGiftBag":false,"pReceiveMails":"com.xingcloud.service.item.OwnedItemCollection:67b7ad3f-9236-4d6c-9a65-5100660897f5","militaryMedals":0,"towerChallengeLevel":2,"prestige":212038,"tradeGoldPrize":0,"isHasDrawChargePrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAAAAAAA=","ownedItems":"com.xingcloud.service.item.OwnedItemCollection:ff56ed83-7504-40bb-aa19-051af4366501","productionGoodsTimes":8,"fightNoticeTime":0,"pItems":"com.xingcloud.service.item.OwnedItemCollection:46e9340e-dc3f-49ff-9dce-df93519281b9","canDrawPvePrize":false,"lastLoginSignTime":1397408402939,"towerTargetIndex":0,"isAllianceLeader":true,"lordUid":"","coin":112641338,"loginSignTitalTimes":2,"gainCropLocked":false,"polity":0,"pInlayItems":"com.xingcloud.service.item.OwnedItemCollection:8bd96a8d-ba04-45e0-adcd-3e7eafac81dc","forceProductionGoodsMoney":6,"activeLevel":0,"isDrawCodePrize":false,"pMines":"com.xingcloud.service.item.OwnedItemCollection:8ff47643-ca1e-4f2b-a67e-b7cda2e417df","closedTask":false,"luoyangMaxTop":1,"collectFreeSoldierTimesMax":12,"pProfiles":"com.xingcloud.service.item.OwnedItemCollection:bf552bec-e4ad-4ed9-9b18-39a19cc13d14","pGMails":"com.xingcloud.service.item.OwnedItemCollection:74394465-f761-45d8-8dfd-c1689ec3913a","eventTimes":0,"pvpSearchCondition":812038,"instanceChallenge":"Instance-26"}';
    //$j = '{"uid":"fc176d70-5c82-45b9-81a9-2fbb21a56eb1","ownerId":"81350813-0418-4b11-8af0-cab75cbb2a31","countryID":0,"sendTime":1397402162096,"hasPush":true,"senderId":"81350813-0418-4b11-8af0-cab75cbb2a31","replyTime":0,"content":"Z2RoZg==","haveAtta":false,"hasDrawAtta":false,"senderName":"test123","ownerProperty":"pSendMails","hasRead":false,"receiverName":"abc","reply":false,"className":"PSendMail","typeId":1}';
    //$j = '{"uid":"7fd2481f-e47c-47d7-bc90-ec9256d7dc0b","isAtked":false,"targetUid":"61bf16c4-2e28-4e65-85dd-b2ca817072f8","countryID":2,"ownerId":"e1768f8b-a1c4-4376-b999-ba93db8967da","sendTime":1397390438483,"hasPush":true,"senderId":"","replyTime":0,"reportId":"86fedc05-d7d9-4b6a-b34e-c0b9eee9ab38","haveAtta":false,"content":"QuG6oW5DaGluaCBwaOG6oXTEkOG7i2NoTmfGsOG7nWkgY2jGoWkgbsaw4bubY1toYWhhaGFoYWhhaGFd77yMR2nDoG5oIMSRxrDhu6NjIGNoaeG6v24gdGjhuq9uZyEgQuG6oW4gZ2nDoG5oIMSRxrDhu6NjMjAzxJFp4buDbSBVeSBkYW5oLCBs4bqleSDEkWkgY+G7p2EgxJHhu5FpIHBoxrDGoW5nMTAwOTgwQuG6oWMuW1hlbSBjaGnhur9uIGLDoW9d","hasDrawAtta":false,"senderName":"report","isCanReatk":false,"ownerProperty":"pReceiveMails","hasRead":true,"receiverName":"BanhBao","reply":false,"className":"PReceiveMail","typeId":2}';
    //$j = '{"pvpWinTimes":0,"lastAddGoldTime":0,"giveHeroChargeLastTime":0,"isCanDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAQEAAAA=","canDrawPveWholePrize":false,"slaveNum":2,"pLuoYangRewards":"com.xingcloud.service.item.OwnedItemCollection:41f4a069-b8d4-4bf6-b041-61c0c1bc93b7","collectFreeSoldierTimes":1,"heroStatuMark":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAAA","attrMaxCoin":1000000,"towerMaxLevel":1,"registerTime":1397391847487,"goodsProductionCD":0,"heroRealizationGoldTimes":0,"pLuoYangRecords":"com.xingcloud.service.item.OwnedItemCollection:6d9695b3-af1a-44d9-857d-cfae115b3d30","pBattlePVPs":"com.xingcloud.service.item.OwnedItemCollection:28069988-9d24-415a-b554-a1b3c4db3e3b","username":"534a81d4e4b0bedabdc174db_5","taxesdTimes":1,"enhancedLocked":false,"salary":5000,"goodsProductionLocked":false,"lastChargeTime":0,"allianceTaxesdDonateCoin":0,"channelId":"NaverNeo","isDef":false,"lordName":"","activeNum":0,"cropTradingLimit":3000,"lastCollectFreeSoldierTime":1397461483573,"peopleMax":0,"lastAddActionPowerTime":0,"isFinishSign":false,"heroNum":4,"isCompleteFirstCharge":false,"userStatus":"rO0ABXNyACVjb20ueGluZ2Nsb3VkLnNlcnZpY2UudXNlci5Vc2VyU3RhdHVzAAAAAAAAAAECAAhaAAxmcmVlemVTdGF0dXNaAApraWNrU3RhdHVzWgAMb25saW5lU3RhdHVzTAANZnJlZXplRW5kVGltZXQAE0xqYXZhL2xhbmcvSW50ZWdlcjtMAA9mcmVlemVTdGFydFRpbWVxAH4AAUwAC2xhc3RMb2dpbklQdAASTGphdmEvbGFuZy9TdHJpbmc7TAANbGFzdExvZ2luVGltZXEAfgABTAAObGFzdExvZ291dFRpbWVxAH4AAXhyADpjb20ueGluZ2Nsb3VkLmZyYW1ld29yay5vcm0uZGFvLmFjdGl2ZV9yZWNvcmQuQWN0aXZlUmVjb3JkAAAAAAAAAAECAAFMAAljbGFzc05hbWVxAH4AAnhwdAAKVXNlclN0YXR1cwAAAHNyABFqYXZhLmxhbmcuSW50ZWdlchLioKT3gYc4AgABSQAFdmFsdWV4cgAQamF2YS5sYW5nLk51bWJlcoaslR0LlOCLAgAAeHAAAAAAcQB+AAh0AA0xMTguNjkuNzYuMjEyc3EAfgAGU0uELnEAfgAI","isCanDrawFirstChargePrize":false,"allianceGreadDonateCoin":0,"mineSeizeNum":0,"tradeTimes":0,"loginDays":2,"token":149,"pvpWinning":0.0,"continueDays":0,"heroRecruitPurpleTimer":0,"searchEquipLocked":false,"gold":1014,"fightNoticeTimes":0,"lastLoginTime":1.397457966868E12,"enhancedRate":0.78,"attackAddition":0.0,"pFormations":"com.xingcloud.service.item.OwnedItemCollection:f7360491-fe76-4666-81ef-0372c201b052","pvpLoss":5,"randomIslandTime":0,"taxationGold":0,"attrPointElectTimes":0,"battleTimes":0,"lastPVPAtketedTime":0,"questionTime":0,"isCanDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAQAAAA==","heroFastTrainExploitsExpend":10,"heroRecruitTimer":0,"finishTask":false,"troopIndex":70,"gainTimes":0,"lastGainTime":0,"rebuiltFreeTimes":1,"pSendMails":"com.xingcloud.service.item.OwnedItemCollection:dd76c9ed-1161-4734-9849-c55969429869","luoyangRewardCDTime":0,"crop":21790,"mainTaskFinishList":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAPAQAAAAAAAAAAAAAAAAAA","description":"자기 소개가 없습니다.","onlinePrizeFinish":false,"gender":true,"pBattleTowers":"com.xingcloud.service.item.OwnedItemCollection:14116048-7bf3-4540-9460-8b605b147ddc","towerLocked":false,"pBoxs":"com.xingcloud.service.item.OwnedItemCollection:aeae8ec4-2ca0-4205-8f89-9c83c5362208","pVitalitys":"com.xingcloud.service.item.OwnedItemCollection:4cbe52ea-49f4-4305-a643-d84691ae4984","islandProsperity":0,"lastAwardNationalReward":0,"fightNoticeItem":0,"luoyangLocked":false,"country":2,"leaveAllianceTime":0,"relieveCropNeed":10,"pveWholeLastTime":0,"sessionId":"bb6345a721134a3db4bad60243ec0d2b","heartbeat":23291108,"isHasDrawFirstChargePrize":false,"pveWholeTimes":0,"dailyPrizeTime":0,"taxation":3756,"taxesdMaxTimes":11,"t6vars":"rO0ABXVyAAJbSU26YCZ26rKlAgAAeHAAAACWAAAAAQAAAA4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA","everyDayOnlinePrizeLevel":0,"recruitTalkCDTime":0,"buildingMaxLevel":35,"fightMsgNum":0,"heartbeatLastTime":0,"isBattleLocked":false,"fastTrainLocked":false,"luoyangTop":0,"business":0,"luoyangCDTime":0,"pMessages":"com.xingcloud.service.item.OwnedItemCollection:15af9dd3-5f92-46ed-8d51-8cc3257ffe69","lastAddPeopleTime":0,"onlinePrizeLevel":0,"name":"test13","attrMaxCrop":30000,"className":"UserProfile","experience":0,"enhancedCDTime":0,"coupon":0,"gainCropCD":0,"pTasks":"com.xingcloud.service.item.OwnedItemCollection:cb3c841b-db08-4248-8ea7-e13b0c42d119","icon":0,"pHeros":"com.xingcloud.service.item.OwnedItemCollection:7c819e90-7cd9-4bea-b698-6cb2c6dd1b4b","isOutOrAddAlliance":false,"fightSeizeItem":0,"pkValue":13,"luoyangRewardLocked":false,"goldMax":0,"lastActiveTime":1397466970536,"searchEquipCd":0,"lastSetEquipEnhancedProTime":1397466952120,"pvpTimes":0,"heroSecondTransfer":0,"forceCoinTimes":1,"buildingFreeQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAACAQE=","exRinking":0,"soldierMax":9000,"remainsTaxesCD":1397463107430,"isHistoryGuidOver":false,"attrMaxGainTimes":5,"guidePHeroUid":"281fb558-946e-4e02-9afd-e3d5bac155fb","allianceWaterConDonateCoin":0,"lastChatTime":0,"lastAddTokenTime":1397391847487,"pveTimes":0,"platformValidate":0,"people":0,"punishmentTime":0,"isHasDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAAAAAAA=","actionPower":0,"pBuildings":"com.xingcloud.service.item.OwnedItemCollection:70cf4b79-0073-4a45-8066-bd00d600c489","onlinePrizeTime":1397457966868,"waterCon":1,"addTrainSizeNeedGold":50,"tradeFinishTime":0,"exploits":1000,"silverMineNum":1,"pAlliances":"com.xingcloud.service.item.OwnedItemCollection:bfe66582-f5c0-4527-a419-339eaf6f274b","pSlaves":"com.xingcloud.service.item.OwnedItemCollection:3ccdbe46-365e-47c0-ab24-4b3d8bb50d90","fatCropTimes":0,"vitality":20,"pveLastTime":0,"canDrawPvpPrize":false,"isUserPause":false,"canGivePurpleHero":false,"soldier":9000,"exRanking":0,"canDrawMainTaskPrize":false,"buildingFreeQueues":"rO0ABXVyAAJbSnggBLUSsXWTAgAAeHAAAAACAAABRV/qtucAAAFFX6b/rQ==","pFriends":"com.xingcloud.service.item.OwnedItemCollection:b4b6e012-8cb5-4215-b848-96a5961a332d","giveHeroChargeSum":0,"islandLevel":0,"forceProductionTimes":0,"isHasDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAAAAAA==","heroFastTrainCD":0,"everyDayOnlinePrizeTime":1397457966868,"alliancePrestigeDonateCoin":0,"troopChallenge":"Troop-70","luoyangTimes":15,"money":0,"smelt":0,"pPVPRecords":"com.xingcloud.service.item.OwnedItemCollection:99a22e23-0a1d-4cbf-abd8-013a986b52bc","lastTaxesdTime":1397463047430,"heroFirstTransfer":0,"rmbAmount":0,"defenseAddition":0.0,"purpleCrystalNum":0,"pEquips":"com.xingcloud.service.item.OwnedItemCollection:9d230cab-37ab-4599-8465-b683bfda5dfb","buildingPayedQueuesNeedGold":50,"heroRealizationTimes":0,"remainsTaxesLocked":false,"pBattlePVEs":"com.xingcloud.service.item.OwnedItemCollection:4a0749df-0c48-4396-983d-a20ba57756e1","sqq":0,"battleCD":1397459982566,"eventPeopleLocked":false,"isHasGainSalary":false,"historyIslandLevel":0,"heroRealizationTenGold":4,"lastAtkedTime":1397528499738,"isOldPlayer":false,"eventPeopleCDTime":0,"taxes":0,"isPVPAtked":true,"uid":"3ce167d4-7bb5-4cf4-9b66-4f0f7b8fff09","fightSeizeTimes":0,"pointElectTime":1397463034237,"recruitTalkLocked":false,"fightSeizeTime":0,"allianceExploitsDonateCoin":0,"mineNumNow":0,"level":13,"lastLastLoginTime":1397444038881,"protecedTime":1397571699736,"towerCD":0,"pGoodss":"com.xingcloud.service.item.OwnedItemCollection:fd9b4555-1440-42eb-be44-4f858ba880c7","power":0,"mailCheck":false,"heroRealizationGold":2,"pvpEnemyWinTimes":0,"status":0,"pChats":"com.xingcloud.service.item.OwnedItemCollection:78bf142a-8a83-4781-905b-459460845513","chargeGoldSum":0,"pvpLastTime":0,"orangeCrystalNum":0,"heroFirstAdvanced":0,"msgCheck":false,"exp":0,"canGiveYellowHero":false,"cropTradingNum":3000,"everyDayChargeSum":0,"heroTrainQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAAA","everyDayOnlinePrizeFinish":false,"heroFastTrainExp":1000,"popular":100,"forceCoinUseGold":2,"titleId":"Title-2","loginPrizeTimes":0,"mainTaskId":"MainTask-6","collectFreeSoldierNum":120,"canDrawSuperGiftBag":false,"pReceiveMails":"com.xingcloud.service.item.OwnedItemCollection:01ee42d3-53b3-4b01-9071-5e546cc01ab0","militaryMedals":0,"towerChallengeLevel":0,"prestige":200,"tradeGoldPrize":0,"ownedItems":"com.xingcloud.service.item.OwnedItemCollection:acf345ea-bb79-4104-860f-e430daec444f","productionGoodsTimes":0,"fightNoticeTime":0,"pItems":"com.xingcloud.service.item.OwnedItemCollection:413527ea-e8cf-492b-bf45-5360d598fafd","canDrawPvePrize":false,"lastLoginSignTime":1397444038881,"towerTargetIndex":0,"isAllianceLeader":false,"lordUid":"","coin":511587,"loginSignTitalTimes":2,"gainCropLocked":false,"polity":0,"pInlayItems":"com.xingcloud.service.item.OwnedItemCollection:817ca39c-2db8-49c1-9fd7-1694dff09c6d","forceProductionGoodsMoney":2,"activeLevel":0,"isDrawCodePrize":false,"pMines":"com.xingcloud.service.item.OwnedItemCollection:944b8144-c22a-4f32-8737-1a2d11a595fa","closedTask":false,"luoyangMaxTop":0,"collectFreeSoldierTimesMax":10,"pProfiles":"com.xingcloud.service.item.OwnedItemCollection:2a66eb7a-7543-47b1-8f45-359b85baa19a","pGMails":"com.xingcloud.service.item.OwnedItemCollection:bedd7ee0-c6ba-4eec-a7bc-620336cc54c9","eventTimes":0,"pvpSearchCondition":130200,"instanceChallenge":"Instance-5"}';
    //$j = '{"uid":"dd76c9ed-1161-4734-9849-c55969429869","items":["game.service.item.cn.iggame.player.PSendMail",{"8c890d44-96a6-4a6b-867e-a2bf88e068ed":"8c890d44-96a6-4a6b-867e-a2bf88e068ed"}],"ownerId":"3ce167d4-7bb5-4cf4-9b66-4f0f7b8fff09","ownerProperty":"pSendMails","className":"OwnedItemCollection"}';
    
    //gmail
    //$j = '{"uid":"3ebb569c-b672-463f-b290-9ae4c46fe2f9","countryID":0,"ownerId":"e1768f8b-a1c4-4376-b999-ba93db8967da","sendTime":1397390687688,"hasPush":true,"senderId":"e1768f8b-a1c4-4376-b999-ba93db8967da","replyContent":"YWxvaGE=","replyTime":1397450148025,"haveAtta":false,"content":"Q2FpIGdpIHRoZQ==","hasDrawAtta":false,"senderName":"BanhBao","ownerProperty":"pGMails","hasRead":false,"receiverName":"GM","reply":true,"className":"PGMail","typeId":3}';
    //sendMail
    $j = '{"uid":"fc176d70-5c82-45b9-81a9-2fbb21a56eb1","ownerId":"81350813-0418-4b11-8af0-cab75cbb2a31","countryID":0,"sendTime":1397402162096,"hasPush":true,"senderId":"81350813-0418-4b11-8af0-cab75cbb2a31","replyTime":0,"content":"Z2RoZg==","haveAtta":false,"hasDrawAtta":false,"senderName":"test123","ownerProperty":"pSendMails","hasRead":false,"receiverName":"abc","reply":false,"className":"PSendMail","typeId":1}';
    //recieve mail
    //$j = '{"uid":"95da97ec-cc2a-496b-a820-45c0c39437b6","isAtked":false,"countryID":0,"ownerId":"81350813-0418-4b11-8af0-cab75cbb2a31","sendTime":1397471365301,"hasPush":true,"senderId":"","replyTime":0,"haveAtta":false,"content":"Q2jDumMgbeG7q25nIHF14buRYyBnaWEgY+G7p2EgYuG6oW4gxJHDoyDEkeG6oXQgZ2nhuqNpIG5o4bqldCB0cm9uZyBUw61jaCDEkGnhu4NtIFRoacOqbiBI4bqhIGzhuqduIHRyxrDhu5tjLCBuaOG6rW4gxJHGsOG7o2NC4bqhYzEwMDAwMDA=","hasDrawAtta":false,"senderName":"GM","isCanReatk":false,"ownerProperty":"pReceiveMails","hasRead":true,"reply":false,"className":"PReceiveMail","typeId":0}';
    //$j = '{"uid":"4aa28588-af5a-40ad-b328-e19d2d4fd7bb","isAtked":true,"targetUid":"e1768f8b-a1c4-4376-b999-ba93db8967da","countryID":0,"ownerId":"61bf16c4-2e28-4e65-85dd-b2ca817072f8","sendTime":1397390438483,"hasPush":true,"senderId":"","replyTime":0,"reportId":"86fedc05-d7d9-4b6a-b34e-c0b9eee9ab38","haveAtta":false,"content":"xJDhu4tjaE5nxrDhu51pIGNoxqFpIG7GsOG7m2NbQmFuaEJhb10gxJHhu5FpIHbhu5tpIGLhuqFuQ2hpbmggcGjhuqF077yMxJHDoW5oIGLhuqFpIGLhuqFuLCBjxrDhu5twIMSRaTEwMDk4MELhuqFjLCBt4bqldDY2xJFp4buDbSB1eSBkYW5oLltYZW0gQ2hp4bq/biBiw6FvXVtQaOG6o24ga8OtY2hd","hasDrawAtta":false,"senderName":"report","isCanReatk":true,"ownerProperty":"pReceiveMails","hasRead":true,"receiverName":"hahahahahaha","reply":false,"className":"PReceiveMail","typeId":2}';
    //$j = '{"lastAddGoldTime":0,"pvpWinTimes":0,"giveHeroChargeLastTime":0,"isCanDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAAAAAAA=","canDrawPveWholePrize":false,"slaveNum":2,"pLuoYangRewards":"com.xingcloud.service.item.OwnedItemCollection:64305247-1b25-42f1-8bc6-30998d2bea32","collectFreeSoldierTimes":0,"heroStatuMark":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAAA","attrMaxCoin":1000000,"towerMaxLevel":1,"registerTime":1397223755159,"goodsProductionCD":0,"heroRealizationGoldTimes":0,"pLuoYangRecords":"com.xingcloud.service.item.OwnedItemCollection:b908348a-90b8-4b28-9f49-d2093278f3b4","pBattlePVPs":"com.xingcloud.service.item.OwnedItemCollection:4514c94e-59aa-401b-a357-de534f9ffec0","username":"5347f13be4b023c3f9daa58a_5","taxesdTimes":0,"enhancedLocked":false,"salary":5000,"goodsProductionLocked":false,"lastChargeTime":0,"allianceTaxesdDonateCoin":0,"channelId":"[CHANNEL]","isDef":false,"lordName":"","activeNum":0,"cropTradingLimit":3000,"lastCollectFreeSoldierTime":1397225423783,"peopleMax":0,"lastAddActionPowerTime":0,"isFinishSign":false,"heroNum":4,"isCompleteFirstCharge":false,"userStatus":"rO0ABXNyACVjb20ueGluZ2Nsb3VkLnNlcnZpY2UudXNlci5Vc2VyU3RhdHVzAAAAAAAAAAECAAhaAAxmcmVlemVTdGF0dXNaAApraWNrU3RhdHVzWgAMb25saW5lU3RhdHVzTAANZnJlZXplRW5kVGltZXQAE0xqYXZhL2xhbmcvSW50ZWdlcjtMAA9mcmVlemVTdGFydFRpbWVxAH4AAUwAC2xhc3RMb2dpbklQdAASTGphdmEvbGFuZy9TdHJpbmc7TAANbGFzdExvZ2luVGltZXEAfgABTAAObGFzdExvZ291dFRpbWVxAH4AAXhyADpjb20ueGluZ2Nsb3VkLmZyYW1ld29yay5vcm0uZGFvLmFjdGl2ZV9yZWNvcmQuQWN0aXZlUmVjb3JkAAAAAAAAAAECAAFMAAljbGFzc05hbWVxAH4AAnhwdAAKVXNlclN0YXR1cwAAAHNyABFqYXZhLmxhbmcuSW50ZWdlchLioKT3gYc4AgABSQAFdmFsdWV4cgAQamF2YS5sYW5nLk51bWJlcoaslR0LlOCLAgAAeHAAAAAAcQB+AAh0AA8xMTEuMTk0LjIxNi4xNjVzcQB+AAZTS9mOcQB+AAg=","isCanDrawFirstChargePrize":false,"allianceGreadDonateCoin":0,"buildingPayedQueues":"rO0ABXVyAAJbSnggBLUSsXWTAgAAeHAAAAACAAABRVFKd3gAAAAAAAAAAA==","mineSeizeNum":0,"tradeTimes":0,"loginDays":3,"token":132,"pvpWinning":0.0,"continueDays":0,"heroRecruitPurpleTimer":0,"searchEquipLocked":false,"gold":833,"fightNoticeTimes":0,"lastLoginTime":1.397479822944E12,"enhancedRate":0.97,"attackAddition":0.0,"pFormations":"com.xingcloud.service.item.OwnedItemCollection:f3d5d739-8ca3-45c1-92ec-fce15f102a14","pvpLoss":0,"randomIslandTime":0,"taxationGold":0,"attrPointElectTimes":1,"battleTimes":21,"buildingPayedQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAACAAA=","lastPVPAtketedTime":0,"questionTime":0,"isCanDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAAAAAA==","heroFastTrainExploitsExpend":30,"heroRecruitTimer":0,"finishTask":false,"troopIndex":21,"gainTimes":0,"lastGainTime":1397226838506,"rebuiltFreeTimes":1,"pSendMails":"com.xingcloud.service.item.OwnedItemCollection:2f12c561-3d94-49ce-afad-782ff5cd765b","luoyangRewardCDTime":0,"crop":24518,"description":"자기 소개가 없습니다.","onlinePrizeFinish":false,"gender":true,"pBattleTowers":"com.xingcloud.service.item.OwnedItemCollection:de0671b6-4439-469c-8e99-08f5757377c7","towerLocked":false,"pBoxs":"com.xingcloud.service.item.OwnedItemCollection:4ce9e299-8828-4025-947c-5a086f7c23ad","pVitalitys":"com.xingcloud.service.item.OwnedItemCollection:46af6764-2c29-436a-a1f9-f22805861349","islandProsperity":0,"lastAwardNationalReward":0,"fightNoticeItem":0,"luoyangLocked":false,"country":3,"leaveAllianceTime":0,"relieveCropNeed":10,"pveWholeLastTime":0,"sessionId":"98723fa80bbf4287afa9e531b3ab0a1f","heartbeat":23291132,"isHasDrawFirstChargePrize":false,"pveWholeTimes":0,"dailyPrizeTime":0,"taxation":4506,"taxesdMaxTimes":11,"t6vars":"rO0ABXVyAAJbSU26YCZ26rKlAgAAeHAAAACWAAAACgAAAA4AAAAUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA","everyDayOnlinePrizeLevel":1,"recruitTalkCDTime":0,"buildingMaxLevel":15,"fightMsgNum":0,"heartbeatLastTime":0,"isBattleLocked":false,"fastTrainLocked":false,"luoyangTop":0,"business":0,"luoyangCDTime":0,"pMessages":"com.xingcloud.service.item.OwnedItemCollection:e3391181-7eb6-4aca-8f25-c0446335a297","lastAddPeopleTime":0,"onlinePrizeLevel":2,"name":"ABình An","attrMaxCrop":30000,"className":"UserProfile","experience":0,"enhancedCDTime":1397223947983,"coupon":0,"gainCropCD":1397226958506,"pTasks":"com.xingcloud.service.item.OwnedItemCollection:db35099d-85ab-4afd-849e-508fec8f8ea3","icon":0,"pHeros":"com.xingcloud.service.item.OwnedItemCollection:ff32eb46-44d5-4a01-a9a3-e74044e93306","isOutOrAddAlliance":false,"fightSeizeItem":0,"pkValue":13,"luoyangRewardLocked":false,"goldMax":0,"lastActiveTime":1397479889876,"searchEquipCd":0,"lastSetEquipEnhancedProTime":1397478868085,"pvpTimes":0,"heroSecondTransfer":0,"forceCoinTimes":0,"buildingFreeQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAACAAA=","exRinking":0,"soldierMax":9000,"remainsTaxesCD":0,"isHistoryGuidOver":false,"attrMaxGainTimes":5,"guidePHeroUid":"59751dde-59c2-4322-9a3d-08ee39c7b36b","allianceWaterConDonateCoin":0,"lastChatTime":0,"lastAddTokenTime":1397223755162,"pveTimes":0,"platformValidate":0,"people":20,"punishmentTime":0,"isHasDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAQEAAAA=","actionPower":0,"pBuildings":"com.xingcloud.service.item.OwnedItemCollection:644fb932-82c5-40b9-9565-22f2dd873f93","onlinePrizeTime":1397474397144,"waterCon":0,"addTrainSizeNeedGold":50,"tradeFinishTime":0,"exploits":3018,"silverMineNum":1,"pAlliances":"com.xingcloud.service.item.OwnedItemCollection:712b3a8e-f519-4c23-bba9-f46d5eed769f","pSlaves":"com.xingcloud.service.item.OwnedItemCollection:10932e71-d887-4ba8-99eb-997cb0e295ee","fatCropTimes":0,"vitality":10,"pveLastTime":0,"canDrawPvpPrize":false,"isUserPause":false,"canGivePurpleHero":false,"soldier":3706,"exRanking":0,"canDrawMainTaskPrize":true,"buildingFreeQueues":"rO0ABXVyAAJbSnggBLUSsXWTAgAAeHAAAAACAAABRVHKYlwAAAFFUZ+nfw==","pFriends":"com.xingcloud.service.item.OwnedItemCollection:64d5385a-f096-43b6-913e-8c829060ddaf","giveHeroChargeSum":0,"islandLevel":0,"forceProductionTimes":0,"isHasDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAAAAAA==","heroFastTrainCD":1397226894029,"everyDayOnlinePrizeTime":1397480155160,"alliancePrestigeDonateCoin":0,"troopChallenge":"Troop-21","luoyangTimes":15,"money":0,"smelt":0,"pPVPRecords":"com.xingcloud.service.item.OwnedItemCollection:63674fd0-52a1-4064-b140-bcdd4789c441","lastTaxesdTime":0,"heroFirstTransfer":0,"rmbAmount":0,"defenseAddition":0.0,"purpleCrystalNum":0,"pEquips":"com.xingcloud.service.item.OwnedItemCollection:c30eb26b-0e4f-4f3e-94b1-dd03a6150bdc","buildingPayedQueuesNeedGold":150,"heroRealizationTimes":0,"remainsTaxesLocked":false,"pBattlePVEs":"com.xingcloud.service.item.OwnedItemCollection:60be8f97-4bd6-4b5f-890f-47c405f70b80","sqq":0,"battleCD":1397467777898,"eventPeopleLocked":false,"isHasGainSalary":false,"historyIslandLevel":0,"heroRealizationTenGold":4,"lastAtkedTime":0,"isOldPlayer":false,"eventPeopleCDTime":0,"taxes":0,"isPVPAtked":false,"uid":"5e0c834e-06fd-49c0-881c-af0d0bbda3ac","fightSeizeTimes":0,"pointElectTime":0,"troopActiveHeros":"rO0ABXVyABNbTGphdmEubGFuZy5TdHJpbmc7rdJW5+kde0cCAAB4cAAAAAd0AAhIZXJvLTI3N3QACEhlcm8tMjc2dAAHSGVyby0xMHQAB0hlcm8tMTF0AAhIZXJvLTI3OHQACEhlcm8tMjc5dAAHSGVyby0xMg==","recruitTalkLocked":false,"fightSeizeTime":0,"allianceExploitsDonateCoin":0,"mineNumNow":0,"level":15,"lastLastLoginTime":1397478864719,"protecedTime":0,"towerCD":0,"pGoodss":"com.xingcloud.service.item.OwnedItemCollection:5f3c6529-ce14-4770-af3a-746cbdc8eb51","power":0,"mailCheck":false,"heroRealizationGold":2,"pvpEnemyWinTimes":0,"status":0,"pChats":"com.xingcloud.service.item.OwnedItemCollection:7b4fca19-74ba-41a6-87a3-d335c0a0f990","chargeGoldSum":0,"pvpLastTime":0,"orangeCrystalNum":0,"heroFirstAdvanced":0,"msgCheck":false,"exp":0,"canGiveYellowHero":false,"cropTradingNum":0,"everyDayChargeSum":0,"heroTrainQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAAA","everyDayOnlinePrizeFinish":false,"heroFastTrainExp":3000,"popular":100,"forceCoinUseGold":2,"titleId":"Title-2","loginPrizeTimes":0,"mainTaskId":"MainTask-1","collectFreeSoldierNum":120,"canDrawSuperGiftBag":false,"pReceiveMails":"com.xingcloud.service.item.OwnedItemCollection:b331a68f-2b29-45c1-9633-66a268bc99b3","militaryMedals":0,"towerChallengeLevel":0,"prestige":290,"tradeGoldPrize":0,"ownedItems":"com.xingcloud.service.item.OwnedItemCollection:96997675-a7c1-4a7a-a6af-bc256e1faba6","productionGoodsTimes":0,"fightNoticeTime":0,"pItems":"com.xingcloud.service.item.OwnedItemCollection:ce8cc1d9-80ea-4e18-8526-152fdf56c8a9","canDrawPvePrize":false,"lastLoginSignTime":1397467007079,"towerTargetIndex":0,"isAllianceLeader":false,"lordUid":"","coin":611477,"loginSignTitalTimes":2,"gainCropLocked":false,"polity":0,"pInlayItems":"com.xingcloud.service.item.OwnedItemCollection:84291fa3-2e4e-47f0-b32b-f51180a39e66","forceProductionGoodsMoney":2,"activeLevel":0,"isDrawCodePrize":false,"pMines":"com.xingcloud.service.item.OwnedItemCollection:aa64a7c1-abeb-4ad3-869f-e8861c98766e","closedTask":false,"luoyangMaxTop":0,"collectFreeSoldierTimesMax":10,"pProfiles":"com.xingcloud.service.item.OwnedItemCollection:4804f24f-f907-4be4-808e-57e9abe3b7ea","pGMails":"com.xingcloud.service.item.OwnedItemCollection:8d54bdef-b323-416a-9416-aacaba6d749c","eventTimes":0,"pvpSearchCondition":150290,"instanceChallenge":"Instance-1"}';
    //$j = '{"uid":"46af6764-2c29-436a-a1f9-f22805861349","items":["game.service.item.cn.iggame.player.PVitality",{"7320184b-02c5-46d3-9cb7-f35254049e23":"7320184b-02c5-46d3-9cb7-f35254049e23","18630d36-3b74-459d-91e9-a20caa3c64cd":"18630d36-3b74-459d-91e9-a20caa3c64cd","916b834f-97e1-4db4-9754-e83533fa3e8d":"916b834f-97e1-4db4-9754-e83533fa3e8d","0d31121b-f45a-443b-8924-fa6348e35f2f":"0d31121b-f45a-443b-8924-fa6348e35f2f","336f1f79-e1e4-4fc4-9f83-dc5b4f641ee4":"336f1f79-e1e4-4fc4-9f83-dc5b4f641ee4","91d73455-f2a6-45a2-ae46-1e0241dfc30f":"91d73455-f2a6-45a2-ae46-1e0241dfc30f","fa98d95c-611b-40dc-b445-356072693cf5":"fa98d95c-611b-40dc-b445-356072693cf5","67f9b0e6-30f9-4aca-8ae3-52a986ec6f8b":"67f9b0e6-30f9-4aca-8ae3-52a986ec6f8b"}],"ownerProperty":"pVitalitys","className":"OwnedItemCollection"}';
    //$j = '{"uid":"aa64a7c1-abeb-4ad3-869f-e8861c98766e","items":["game.service.item.cn.iggame.player.PMine",{"93de6dfb-8ba8-45e4-898e-f261c1fa3700":"93de6dfb-8ba8-45e4-898e-f261c1fa3700"}],"ownerProperty":"pMines","className":"OwnedItemCollection"}';
    //$j = '{"uid":"46af6764-2c29-436a-a1f9-f22805861349","items":["game.service.item.cn.iggame.player.PVitality",{"7320184b-02c5-46d3-9cb7-f35254049e23":"7320184b-02c5-46d3-9cb7-f35254049e23","18630d36-3b74-459d-91e9-a20caa3c64cd":"18630d36-3b74-459d-91e9-a20caa3c64cd","916b834f-97e1-4db4-9754-e83533fa3e8d":"916b834f-97e1-4db4-9754-e83533fa3e8d","0d31121b-f45a-443b-8924-fa6348e35f2f":"0d31121b-f45a-443b-8924-fa6348e35f2f","336f1f79-e1e4-4fc4-9f83-dc5b4f641ee4":"336f1f79-e1e4-4fc4-9f83-dc5b4f641ee4","91d73455-f2a6-45a2-ae46-1e0241dfc30f":"91d73455-f2a6-45a2-ae46-1e0241dfc30f","fa98d95c-611b-40dc-b445-356072693cf5":"fa98d95c-611b-40dc-b445-356072693cf5","67f9b0e6-30f9-4aca-8ae3-52a986ec6f8b":"67f9b0e6-30f9-4aca-8ae3-52a986ec6f8b"}],"ownerProperty":"pVitalitys","className":"OwnedItemCollection"}';
    //$j = '{"uid":"8a52e61b-6edf-4699-a3e6-1184aa0e85ce","ownerId":"5e0c834e-06fd-49c0-881c-af0d0bbda3ac","normalatk":108,"tacdef":60,"equips":"rO0ABXVyABNbTGphdmEubGFuZy5TdHJpbmc7rdJW5+kde0cCAAB4cAAAAAd0AABxAH4AAnEAfgACcQB+AAJxAH4AAnEAfgACcQB+AAI=","baseForce":67.0,"nextUpgradeLevel":50,"armyTierMax":0,"expMax":3600,"armyId":"Army-13","forceGrow":1.8,"level":6,"trainFinishTime":1397230333913,"ownerProperty":"pHeros","magicatk":108,"name":"Trình Viễn Chí","baseIntel":49.0,"command":70.0,"isAutoAdvanced":false,"className":"PHero","magicdef":60,"beatback":0,"icon":"wjtx_chengyuanzhi.png","tacatk":108,"teachSoldierMaxAdd":0,"normaldef":60,"intelGrow":1.3,"itemId":"Hero-9","nextTransferLevel":15,"isTraining":false,"exp":1900,"soldier":560,"skill":"Skill-38","isEmploied":true,"trainBeginTime":1397227946499,"crit":0,"trainLevel":0,"baseCommand":70.0,"commandGrow":1.8,"intel":49.0,"soldierMax":560,"force":67.0,"decrease":0,"upgradeTimes":0}';
    //$j = '{"uid":"90c1a6f6-f655-40aa-859b-1345176d2412","goodsId":"Goods-3","level":2,"times":3,"income":40975,"ownerProperty":"pGoods","number":11,"className":"PGoods","itemId":"Goods-3"}';
    //$j = '{"visible":1,"partId":6,"id":"Equip-347","dbMoney":220,"saleType":0,"name":"Viêm Ngọc Bích","money":220,"cnname":"炎玉璧","className":"ShopEquip","gold":220,"end":0,"beatback":0,"limit":55,"icon":"tb_baowu_hong6.png","mainGrow":0,"coinGrow":0,"sellMax":99999,"coin":35000,"sgrow":31,"discount":10,"begin":0,"mainBase":5,"soldier":1008,"color":"红","enhancedTime":1000,"crit":0,"coinBase":0,"sellNum":1,"decrease":0,"buyLimit":false}';
    
    $j = '{"uid":"22467b95-5ac8-45da-82a3-5ad58fdfbc7d","items":["cn.x6game.model.RoleInfo",{"08a2e569-1972-4fc6-992d-3d4100373084":"08a2e569-1972-4fc6-992d-3d4100373084"}],"ownerId":"534a579ae4b0bedabdc174d9","ownerProperty":"ownedItems","className":"OwnedItemCollection"}';
    //echo '<pre>';
    //print_r(json_decode($j,true));
    //echo '</pre>';
    
    //$st = "game1";
    //echo $st[0] . "<br>";
    //echo strlen($st) . "<br>";
    //echo substr($st, 4);
    if(isset($_POST['server'])){
        $srv = $_POST['server'];
    }else{
        //$srv = end(array_keys($server));
        //$srv = end(array_values($server));
		$srv = $srvItem;
    }
    
    $serverDropDown = GMDropDown(array('label' => 'Server', 'name' => 'server', 'id' => 'server', 'option' => $server, 'value' => $srv));
    $moboaccountText = GMText(array('label' => 'Mobo Account', 'name' => 'mobo_account', 'value' => $_POST['mobo_account'], 'id' => 'mobo_account'));
    $moboidText = GMText(array('label' => 'Mobo ID', 'name' => 'mobo_id', 'value' => $_POST['mobo_id'], 'id' => 'mobo_id'));
    $charnameText = GMText(array('label' => 'Character Name', 'name' => 'character_name', 'value' => $_POST['character_name'], 'id' => 'charactor_name'));
    $charidText = GMText(array('label' => 'Character ID', 'name' => 'character_id', 'value' => $_POST['character_id'], 'id' => 'charactor_id'));
    $Button = GMButton(array('button' => array(
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Search'),
        )));
    
    
    
    //$content = "<br>".$serverDropDown.$moboaccountText.$moboidText.$charnameText.$charidText.$Button;
    $content = "<br>".$serverDropDown.$moboaccountText.$charnameText.$charidText.$Button;
    $xhtml = GMGenView(array('content' => $content, 'action' => base_url('?control=game&func=infouser'), 'method' => 'POST', 'legend' => 'FORM SEARCH USER'));
    echo $xhtml;
    
   

    $mobo_user_gridview = GMGridView('Thông tin user mobo','10',$mobo_info);
    echo $mobo_user_gridview;
   
    //$usergameField = array('LoginDays','uid','createTime','coin','macType','mac','registerTime','ChannelId','regName','roleNum','username','level','continueDays','money','lastLoginTime');
    $usergameField = array('uid','username','createTime','mac','registerTime','ChannelId','regName','roleNum','money','lastLoginTime','LoginDays');
    $game_user_gridview = GMGridView('Thông tin user game', '11',$game_info,$usergameField);
    echo $game_user_gridview;
    
    $chrField = array('uid','name','level','gold','heartbeat','heroNum','registerTime','status','exp','power');
    $char_info = GMGridView('Thông tin character','12',$char_info,$chrField);
    echo $char_info;
    
	$shopequipField = array('id','name','money','dbMoney','saleType','className');
     if(count($shopequip) > 1){
        $shopequip_gridview = GMGridViewGroup('Shop','21',$shopequip, $shopequipField);
    }else{
        $shopequip_gridview = GMGridViewGroup('Shop','19',$shopequip, $shopequipField);
    }
    echo $shopequip_gridview;    
    
	
    //$heroField = array('heroName','tacatk','normaldef','enhancedLevel','normalatk','itemType','tacdef','enhancedCoin','number','sellingPrice','level','crit','ownerProperty','magicatk','command','grade','soldierMax','className','intel','force','decrease','magicdef','demoteCoin');
    $heroField = array('heroName','enhancedLevel','normalatk','enhancedCoin','sellingPrice','level','grade','soldierMax','decrease','demoteCoin');
    if(count($hero) > 1){
        $hero_gridview = GMGridViewGroup('Hero','22',$hero,$heroField);
    }else{
        $hero_gridview = GMGridViewGroup('Hero','20',$hero,$heroField);
    }
    echo $hero_gridview;  
    
    
    
    //$rolelevelField = array('skillid','skillcode','skillname','skilldesc','skilltype','skillgrade','cardid','skillloc','iflife');
    //$rolelevel_gridview = GMGridView('level','17',$rolelevel);
    //echo $rolelevel_gridview;
    /* 
    $usercardField = array('cardcode','cardname','carddesc','cardprop','starlevel','cardtype','cardlevel','upexp','curexp','curvalue');
    $usercard_gridview = GMGridView('Card','18',$usercard,$usercardField);
    echo $usercard_gridview;
    */
    /*
    //$userfriendField = array('cardcode','cardname','carddesc','cardprop','starlevel','cardtype','cardlevel','upexp','curexp','curvalue');
    $userfriend_gridview = GMGridView('Fiends','20',$userfriend);
    echo $userfriend_gridview;
     * 
     */
?>
    
<script>
   $(document).ready(function() {
   //window.onload = function () {
    $('#tbl_16').dataTable( {
        /*
        columnDefs: [ {
            targets: [ 0 ],
            orderData: [ 0, 1 ]
        }, {
            targets: [ 1 ],
            orderData: [ 1, 0 ]
        }, {
            targets: [ 4 ],
            orderData: [ 4, 0 ]
        } ],
        */
       
       "columnDefs": [
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [ 3 ],
                "visible": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            },
            {
                "targets": [ 5 ],
                "visible": false
            },
            {
                "targets": [ 6 ],
                "visible": false
            },
            {
                "targets": [ 7 ],
                "visible": false
            }
        ],
        "paging":   false,
        //"ordering": false,
        "info":     false,
        //"searchable": false
    
    } );
   //}
   /*
   $('#tbl_17').dataTable( {
        "paging":   false,
        //"ordering": false,
        "info":     false,
        //"searchable": false
    
    } );
   
   $('#tbl_18').dataTable( {
        "paging":   false,
        //"ordering": false,
        "info":     false,
        //"searchable": false
    
    } );
    
    
    
    
   */
  $('#tbl_19').dataTable( {
        "paging":   false,
        //"ordering": false,
        "info":     false,
        //"searchable": false
    
    } );
    
    $('#tbl_20').dataTable( {
        "paging":   false,
        //"ordering": false,
        "info":     false,
        //"searchable": false
    
    } );
    
    $('table tbody').on( 'click', 'tr', function () {
        $(this).children().toggleClass('selected');
    } );
 
    $('#button').click( function () {
        alert( table.rows('.selected').data().length +' row(s) selected' );
    } );
   
   
   
   /*
   $("#tbl_16_filter label").hide();
   
   $("#tbl_17_filter label").hide();
   
   $("#tbl_18_filter label").hide();
   
   
   
   
   
   //$("select option:last").attr('selected','true');
     */
    $("#tbl_19_filter label").hide();
    
     $("#tbl_20_filter label").hide();
     
 } );
    </script>
</div>

<style type="text/css">
	#bttop
	{
		border: 0 solid #4adcff;
		text-align: center;
		position: fixed;
		bottom: 5px;
		right: 15px;
		cursor: pointer;
		display: none;
		color: #fff;
		font-size: 11px;
		font-weight: 900;
		padding: 5px;
		opacity: 0.55;
	}
</style>
 <div style="display: none;" id="bttop">
			<img src="<?= base_url() ?>assets/img/to-top.png" alt="" width="35">
		</div>
<script type="text/javascript">
	$(function () { $(window).scroll(function () { if ($(this).scrollTop() != 0) { $('#bttop').fadeIn(); } else { $('#bttop').fadeOut(); } }); $('#bttop').click(function () { $('body,html').animate({ scrollTop: 0 }, 800); }); });
</script>
 

