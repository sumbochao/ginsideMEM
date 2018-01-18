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
    $j = '{"lastAddGoldTime":0,"pvpWinTimes":0,"giveHeroChargeLastTime":0,"isCanDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAAAAAAA=","canDrawPveWholePrize":false,"slaveNum":2,"pLuoYangRewards":"com.xingcloud.service.item.OwnedItemCollection:64305247-1b25-42f1-8bc6-30998d2bea32","collectFreeSoldierTimes":0,"heroStatuMark":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAAA","attrMaxCoin":1000000,"towerMaxLevel":1,"registerTime":1397223755159,"goodsProductionCD":0,"heroRealizationGoldTimes":0,"pLuoYangRecords":"com.xingcloud.service.item.OwnedItemCollection:b908348a-90b8-4b28-9f49-d2093278f3b4","pBattlePVPs":"com.xingcloud.service.item.OwnedItemCollection:4514c94e-59aa-401b-a357-de534f9ffec0","username":"5347f13be4b023c3f9daa58a_5","taxesdTimes":0,"enhancedLocked":false,"salary":5000,"goodsProductionLocked":false,"lastChargeTime":0,"allianceTaxesdDonateCoin":0,"channelId":"[CHANNEL]","isDef":false,"lordName":"","activeNum":0,"cropTradingLimit":3000,"lastCollectFreeSoldierTime":1397225423783,"peopleMax":0,"lastAddActionPowerTime":0,"isFinishSign":false,"heroNum":4,"isCompleteFirstCharge":false,"userStatus":"rO0ABXNyACVjb20ueGluZ2Nsb3VkLnNlcnZpY2UudXNlci5Vc2VyU3RhdHVzAAAAAAAAAAECAAhaAAxmcmVlemVTdGF0dXNaAApraWNrU3RhdHVzWgAMb25saW5lU3RhdHVzTAANZnJlZXplRW5kVGltZXQAE0xqYXZhL2xhbmcvSW50ZWdlcjtMAA9mcmVlemVTdGFydFRpbWVxAH4AAUwAC2xhc3RMb2dpbklQdAASTGphdmEvbGFuZy9TdHJpbmc7TAANbGFzdExvZ2luVGltZXEAfgABTAAObGFzdExvZ291dFRpbWVxAH4AAXhyADpjb20ueGluZ2Nsb3VkLmZyYW1ld29yay5vcm0uZGFvLmFjdGl2ZV9yZWNvcmQuQWN0aXZlUmVjb3JkAAAAAAAAAAECAAFMAAljbGFzc05hbWVxAH4AAnhwdAAKVXNlclN0YXR1cwAAAHNyABFqYXZhLmxhbmcuSW50ZWdlchLioKT3gYc4AgABSQAFdmFsdWV4cgAQamF2YS5sYW5nLk51bWJlcoaslR0LlOCLAgAAeHAAAAAAcQB+AAh0AA8xMTEuMTk0LjIxNi4xNjVzcQB+AAZTS9mOcQB+AAg=","isCanDrawFirstChargePrize":false,"allianceGreadDonateCoin":0,"buildingPayedQueues":"rO0ABXVyAAJbSnggBLUSsXWTAgAAeHAAAAACAAABRVFKd3gAAAAAAAAAAA==","mineSeizeNum":0,"tradeTimes":0,"loginDays":3,"token":132,"pvpWinning":0.0,"continueDays":0,"heroRecruitPurpleTimer":0,"searchEquipLocked":false,"gold":833,"fightNoticeTimes":0,"lastLoginTime":1.397479822944E12,"enhancedRate":0.97,"attackAddition":0.0,"pFormations":"com.xingcloud.service.item.OwnedItemCollection:f3d5d739-8ca3-45c1-92ec-fce15f102a14","pvpLoss":0,"randomIslandTime":0,"taxationGold":0,"attrPointElectTimes":1,"battleTimes":21,"buildingPayedQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAACAAA=","lastPVPAtketedTime":0,"questionTime":0,"isCanDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAAAAAA==","heroFastTrainExploitsExpend":30,"heroRecruitTimer":0,"finishTask":false,"troopIndex":21,"gainTimes":0,"lastGainTime":1397226838506,"rebuiltFreeTimes":1,"pSendMails":"com.xingcloud.service.item.OwnedItemCollection:2f12c561-3d94-49ce-afad-782ff5cd765b","luoyangRewardCDTime":0,"crop":24518,"description":"자기 소개가 없습니다.","onlinePrizeFinish":false,"gender":true,"pBattleTowers":"com.xingcloud.service.item.OwnedItemCollection:de0671b6-4439-469c-8e99-08f5757377c7","towerLocked":false,"pBoxs":"com.xingcloud.service.item.OwnedItemCollection:4ce9e299-8828-4025-947c-5a086f7c23ad","pVitalitys":"com.xingcloud.service.item.OwnedItemCollection:46af6764-2c29-436a-a1f9-f22805861349","islandProsperity":0,"lastAwardNationalReward":0,"fightNoticeItem":0,"luoyangLocked":false,"country":3,"leaveAllianceTime":0,"relieveCropNeed":10,"pveWholeLastTime":0,"sessionId":"98723fa80bbf4287afa9e531b3ab0a1f","heartbeat":23291132,"isHasDrawFirstChargePrize":false,"pveWholeTimes":0,"dailyPrizeTime":0,"taxation":4506,"taxesdMaxTimes":11,"t6vars":"rO0ABXVyAAJbSU26YCZ26rKlAgAAeHAAAACWAAAACgAAAA4AAAAUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA","everyDayOnlinePrizeLevel":1,"recruitTalkCDTime":0,"buildingMaxLevel":15,"fightMsgNum":0,"heartbeatLastTime":0,"isBattleLocked":false,"fastTrainLocked":false,"luoyangTop":0,"business":0,"luoyangCDTime":0,"pMessages":"com.xingcloud.service.item.OwnedItemCollection:e3391181-7eb6-4aca-8f25-c0446335a297","lastAddPeopleTime":0,"onlinePrizeLevel":2,"name":"ABình An","attrMaxCrop":30000,"className":"UserProfile","experience":0,"enhancedCDTime":1397223947983,"coupon":0,"gainCropCD":1397226958506,"pTasks":"com.xingcloud.service.item.OwnedItemCollection:db35099d-85ab-4afd-849e-508fec8f8ea3","icon":0,"pHeros":"com.xingcloud.service.item.OwnedItemCollection:ff32eb46-44d5-4a01-a9a3-e74044e93306","isOutOrAddAlliance":false,"fightSeizeItem":0,"pkValue":13,"luoyangRewardLocked":false,"goldMax":0,"lastActiveTime":1397479889876,"searchEquipCd":0,"lastSetEquipEnhancedProTime":1397478868085,"pvpTimes":0,"heroSecondTransfer":0,"forceCoinTimes":0,"buildingFreeQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAACAAA=","exRinking":0,"soldierMax":9000,"remainsTaxesCD":0,"isHistoryGuidOver":false,"attrMaxGainTimes":5,"guidePHeroUid":"59751dde-59c2-4322-9a3d-08ee39c7b36b","allianceWaterConDonateCoin":0,"lastChatTime":0,"lastAddTokenTime":1397223755162,"pveTimes":0,"platformValidate":0,"people":20,"punishmentTime":0,"isHasDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAQEAAAA=","actionPower":0,"pBuildings":"com.xingcloud.service.item.OwnedItemCollection:644fb932-82c5-40b9-9565-22f2dd873f93","onlinePrizeTime":1397474397144,"waterCon":0,"addTrainSizeNeedGold":50,"tradeFinishTime":0,"exploits":3018,"silverMineNum":1,"pAlliances":"com.xingcloud.service.item.OwnedItemCollection:712b3a8e-f519-4c23-bba9-f46d5eed769f","pSlaves":"com.xingcloud.service.item.OwnedItemCollection:10932e71-d887-4ba8-99eb-997cb0e295ee","fatCropTimes":0,"vitality":10,"pveLastTime":0,"canDrawPvpPrize":false,"isUserPause":false,"canGivePurpleHero":false,"soldier":3706,"exRanking":0,"canDrawMainTaskPrize":true,"buildingFreeQueues":"rO0ABXVyAAJbSnggBLUSsXWTAgAAeHAAAAACAAABRVHKYlwAAAFFUZ+nfw==","pFriends":"com.xingcloud.service.item.OwnedItemCollection:64d5385a-f096-43b6-913e-8c829060ddaf","giveHeroChargeSum":0,"islandLevel":0,"forceProductionTimes":0,"isHasDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAAAAAA==","heroFastTrainCD":1397226894029,"everyDayOnlinePrizeTime":1397480155160,"alliancePrestigeDonateCoin":0,"troopChallenge":"Troop-21","luoyangTimes":15,"money":0,"smelt":0,"pPVPRecords":"com.xingcloud.service.item.OwnedItemCollection:63674fd0-52a1-4064-b140-bcdd4789c441","lastTaxesdTime":0,"heroFirstTransfer":0,"rmbAmount":0,"defenseAddition":0.0,"purpleCrystalNum":0,"pEquips":"com.xingcloud.service.item.OwnedItemCollection:c30eb26b-0e4f-4f3e-94b1-dd03a6150bdc","buildingPayedQueuesNeedGold":150,"heroRealizationTimes":0,"remainsTaxesLocked":false,"pBattlePVEs":"com.xingcloud.service.item.OwnedItemCollection:60be8f97-4bd6-4b5f-890f-47c405f70b80","sqq":0,"battleCD":1397467777898,"eventPeopleLocked":false,"isHasGainSalary":false,"historyIslandLevel":0,"heroRealizationTenGold":4,"lastAtkedTime":0,"isOldPlayer":false,"eventPeopleCDTime":0,"taxes":0,"isPVPAtked":false,"uid":"5e0c834e-06fd-49c0-881c-af0d0bbda3ac","fightSeizeTimes":0,"pointElectTime":0,"troopActiveHeros":"rO0ABXVyABNbTGphdmEubGFuZy5TdHJpbmc7rdJW5+kde0cCAAB4cAAAAAd0AAhIZXJvLTI3N3QACEhlcm8tMjc2dAAHSGVyby0xMHQAB0hlcm8tMTF0AAhIZXJvLTI3OHQACEhlcm8tMjc5dAAHSGVyby0xMg==","recruitTalkLocked":false,"fightSeizeTime":0,"allianceExploitsDonateCoin":0,"mineNumNow":0,"level":15,"lastLastLoginTime":1397478864719,"protecedTime":0,"towerCD":0,"pGoodss":"com.xingcloud.service.item.OwnedItemCollection:5f3c6529-ce14-4770-af3a-746cbdc8eb51","power":0,"mailCheck":false,"heroRealizationGold":2,"pvpEnemyWinTimes":0,"status":0,"pChats":"com.xingcloud.service.item.OwnedItemCollection:7b4fca19-74ba-41a6-87a3-d335c0a0f990","chargeGoldSum":0,"pvpLastTime":0,"orangeCrystalNum":0,"heroFirstAdvanced":0,"msgCheck":false,"exp":0,"canGiveYellowHero":false,"cropTradingNum":0,"everyDayChargeSum":0,"heroTrainQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAAA","everyDayOnlinePrizeFinish":false,"heroFastTrainExp":3000,"popular":100,"forceCoinUseGold":2,"titleId":"Title-2","loginPrizeTimes":0,"mainTaskId":"MainTask-1","collectFreeSoldierNum":120,"canDrawSuperGiftBag":false,"pReceiveMails":"com.xingcloud.service.item.OwnedItemCollection:b331a68f-2b29-45c1-9633-66a268bc99b3","militaryMedals":0,"towerChallengeLevel":0,"prestige":290,"tradeGoldPrize":0,"ownedItems":"com.xingcloud.service.item.OwnedItemCollection:96997675-a7c1-4a7a-a6af-bc256e1faba6","productionGoodsTimes":0,"fightNoticeTime":0,"pItems":"com.xingcloud.service.item.OwnedItemCollection:ce8cc1d9-80ea-4e18-8526-152fdf56c8a9","canDrawPvePrize":false,"lastLoginSignTime":1397467007079,"towerTargetIndex":0,"isAllianceLeader":false,"lordUid":"","coin":611477,"loginSignTitalTimes":2,"gainCropLocked":false,"polity":0,"pInlayItems":"com.xingcloud.service.item.OwnedItemCollection:84291fa3-2e4e-47f0-b32b-f51180a39e66","forceProductionGoodsMoney":2,"activeLevel":0,"isDrawCodePrize":false,"pMines":"com.xingcloud.service.item.OwnedItemCollection:aa64a7c1-abeb-4ad3-869f-e8861c98766e","closedTask":false,"luoyangMaxTop":0,"collectFreeSoldierTimesMax":10,"pProfiles":"com.xingcloud.service.item.OwnedItemCollection:4804f24f-f907-4be4-808e-57e9abe3b7ea","pGMails":"com.xingcloud.service.item.OwnedItemCollection:8d54bdef-b323-416a-9416-aacaba6d749c","eventTimes":0,"pvpSearchCondition":150290,"instanceChallenge":"Instance-1"}';
    //$j = '{"lastAddGoldTime":0,"pvpWinTimes":0,"giveHeroChargeLastTime":0,"isCanDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAAAAAAA=","canDrawPveWholePrize":false,"slaveNum":2,"pLuoYangRewards":"com.xingcloud.service.item.OwnedItemCollection:64305247-1b25-42f1-8bc6-30998d2bea32","collectFreeSoldierTimes":0,"heroStatuMark":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAAA","attrMaxCoin":1000000,"towerMaxLevel":1,"registerTime":1397223755159,"goodsProductionCD":0,"heroRealizationGoldTimes":0,"pLuoYangRecords":"com.xingcloud.service.item.OwnedItemCollection:b908348a-90b8-4b28-9f49-d2093278f3b4","pBattlePVPs":"com.xingcloud.service.item.OwnedItemCollection:4514c94e-59aa-401b-a357-de534f9ffec0","username":"5347f13be4b023c3f9daa58a_5","taxesdTimes":0,"enhancedLocked":false,"salary":5000,"goodsProductionLocked":false,"lastChargeTime":0,"allianceTaxesdDonateCoin":0,"channelId":"[CHANNEL]","isDef":false,"lordName":"","activeNum":0,"cropTradingLimit":3000,"lastCollectFreeSoldierTime":1397225423783,"peopleMax":0,"lastAddActionPowerTime":0,"isFinishSign":false,"heroNum":4,"isCompleteFirstCharge":false,"userStatus":"rO0ABXNyACVjb20ueGluZ2Nsb3VkLnNlcnZpY2UudXNlci5Vc2VyU3RhdHVzAAAAAAAAAAECAAhaAAxmcmVlemVTdGF0dXNaAApraWNrU3RhdHVzWgAMb25saW5lU3RhdHVzTAANZnJlZXplRW5kVGltZXQAE0xqYXZhL2xhbmcvSW50ZWdlcjtMAA9mcmVlemVTdGFydFRpbWVxAH4AAUwAC2xhc3RMb2dpbklQdAASTGphdmEvbGFuZy9TdHJpbmc7TAANbGFzdExvZ2luVGltZXEAfgABTAAObGFzdExvZ291dFRpbWVxAH4AAXhyADpjb20ueGluZ2Nsb3VkLmZyYW1ld29yay5vcm0uZGFvLmFjdGl2ZV9yZWNvcmQuQWN0aXZlUmVjb3JkAAAAAAAAAAECAAFMAAljbGFzc05hbWVxAH4AAnhwdAAKVXNlclN0YXR1cwAAAHNyABFqYXZhLmxhbmcuSW50ZWdlchLioKT3gYc4AgABSQAFdmFsdWV4cgAQamF2YS5sYW5nLk51bWJlcoaslR0LlOCLAgAAeHAAAAAAcQB+AAh0AA8xMTEuMTk0LjIxNi4xNjVzcQB+AAZTS9mOcQB+AAg=","isCanDrawFirstChargePrize":false,"allianceGreadDonateCoin":0,"buildingPayedQueues":"rO0ABXVyAAJbSnggBLUSsXWTAgAAeHAAAAACAAABRVFKd3gAAAAAAAAAAA==","mineSeizeNum":0,"tradeTimes":0,"loginDays":3,"token":132,"pvpWinning":0.0,"continueDays":0,"heroRecruitPurpleTimer":0,"searchEquipLocked":false,"gold":833,"fightNoticeTimes":0,"lastLoginTime":1.397479822944E12,"enhancedRate":0.97,"attackAddition":0.0,"pFormations":"com.xingcloud.service.item.OwnedItemCollection:f3d5d739-8ca3-45c1-92ec-fce15f102a14","pvpLoss":0,"randomIslandTime":0,"taxationGold":0,"attrPointElectTimes":1,"battleTimes":21,"buildingPayedQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAACAAA=","lastPVPAtketedTime":0,"questionTime":0,"isCanDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAAAAAA==","heroFastTrainExploitsExpend":30,"heroRecruitTimer":0,"finishTask":false,"troopIndex":21,"gainTimes":0,"lastGainTime":1397226838506,"rebuiltFreeTimes":1,"pSendMails":"com.xingcloud.service.item.OwnedItemCollection:2f12c561-3d94-49ce-afad-782ff5cd765b","luoyangRewardCDTime":0,"crop":24518,"description":"자기 소개가 없습니다.","onlinePrizeFinish":false,"gender":true,"pBattleTowers":"com.xingcloud.service.item.OwnedItemCollection:de0671b6-4439-469c-8e99-08f5757377c7","towerLocked":false,"pBoxs":"com.xingcloud.service.item.OwnedItemCollection:4ce9e299-8828-4025-947c-5a086f7c23ad","pVitalitys":"com.xingcloud.service.item.OwnedItemCollection:46af6764-2c29-436a-a1f9-f22805861349","islandProsperity":0,"lastAwardNationalReward":0,"fightNoticeItem":0,"luoyangLocked":false,"country":3,"leaveAllianceTime":0,"relieveCropNeed":10,"pveWholeLastTime":0,"sessionId":"98723fa80bbf4287afa9e531b3ab0a1f","heartbeat":23291132,"isHasDrawFirstChargePrize":false,"pveWholeTimes":0,"dailyPrizeTime":0,"taxation":4506,"taxesdMaxTimes":11,"t6vars":"rO0ABXVyAAJbSU26YCZ26rKlAgAAeHAAAACWAAAACgAAAA4AAAAUAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA","everyDayOnlinePrizeLevel":1,"recruitTalkCDTime":0,"buildingMaxLevel":15,"fightMsgNum":0,"heartbeatLastTime":0,"isBattleLocked":false,"fastTrainLocked":false,"luoyangTop":0,"business":0,"luoyangCDTime":0,"pMessages":"com.xingcloud.service.item.OwnedItemCollection:e3391181-7eb6-4aca-8f25-c0446335a297","lastAddPeopleTime":0,"onlinePrizeLevel":2,"name":"ABình An","attrMaxCrop":30000,"className":"UserProfile","experience":0,"enhancedCDTime":1397223947983,"coupon":0,"gainCropCD":1397226958506,"pTasks":"com.xingcloud.service.item.OwnedItemCollection:db35099d-85ab-4afd-849e-508fec8f8ea3","icon":0,"pHeros":"com.xingcloud.service.item.OwnedItemCollection:ff32eb46-44d5-4a01-a9a3-e74044e93306","isOutOrAddAlliance":false,"fightSeizeItem":0,"pkValue":13,"luoyangRewardLocked":false,"goldMax":0,"lastActiveTime":1397479889876,"searchEquipCd":0,"lastSetEquipEnhancedProTime":1397478868085,"pvpTimes":0,"heroSecondTransfer":0,"forceCoinTimes":0,"buildingFreeQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAACAAA=","exRinking":0,"soldierMax":9000,"remainsTaxesCD":0,"isHistoryGuidOver":false,"attrMaxGainTimes":5,"guidePHeroUid":"59751dde-59c2-4322-9a3d-08ee39c7b36b","allianceWaterConDonateCoin":0,"lastChatTime":0,"lastAddTokenTime":1397223755162,"pveTimes":0,"platformValidate":0,"people":20,"punishmentTime":0,"isHasDrawLoginSignPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAFAQEAAAA=","actionPower":0,"pBuildings":"com.xingcloud.service.item.OwnedItemCollection:644fb932-82c5-40b9-9565-22f2dd873f93","onlinePrizeTime":1397474397144,"waterCon":0,"addTrainSizeNeedGold":50,"tradeFinishTime":0,"exploits":3018,"silverMineNum":1,"pAlliances":"com.xingcloud.service.item.OwnedItemCollection:712b3a8e-f519-4c23-bba9-f46d5eed769f","pSlaves":"com.xingcloud.service.item.OwnedItemCollection:10932e71-d887-4ba8-99eb-997cb0e295ee","fatCropTimes":0,"vitality":10,"pveLastTime":0,"canDrawPvpPrize":false,"isUserPause":false,"canGivePurpleHero":false,"soldier":3706,"exRanking":0,"canDrawMainTaskPrize":true,"buildingFreeQueues":"rO0ABXVyAAJbSnggBLUSsXWTAgAAeHAAAAACAAABRVHKYlwAAAFFUZ+nfw==","pFriends":"com.xingcloud.service.item.OwnedItemCollection:64d5385a-f096-43b6-913e-8c829060ddaf","giveHeroChargeSum":0,"islandLevel":0,"forceProductionTimes":0,"isHasDrawVitalityPrize":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAAEAAAAAA==","heroFastTrainCD":1397226894029,"everyDayOnlinePrizeTime":1397480155160,"alliancePrestigeDonateCoin":0,"troopChallenge":"Troop-21","luoyangTimes":15,"money":0,"smelt":0,"pPVPRecords":"com.xingcloud.service.item.OwnedItemCollection:63674fd0-52a1-4064-b140-bcdd4789c441","lastTaxesdTime":0,"heroFirstTransfer":0,"rmbAmount":0,"defenseAddition":0.0,"purpleCrystalNum":0,"pEquips":"com.xingcloud.service.item.OwnedItemCollection:c30eb26b-0e4f-4f3e-94b1-dd03a6150bdc","buildingPayedQueuesNeedGold":150,"heroRealizationTimes":0,"remainsTaxesLocked":false,"pBattlePVEs":"com.xingcloud.service.item.OwnedItemCollection:60be8f97-4bd6-4b5f-890f-47c405f70b80","sqq":0,"battleCD":1397467777898,"eventPeopleLocked":false,"isHasGainSalary":false,"historyIslandLevel":0,"heroRealizationTenGold":4,"lastAtkedTime":0,"isOldPlayer":false,"eventPeopleCDTime":0,"taxes":0,"isPVPAtked":false,"uid":"5e0c834e-06fd-49c0-881c-af0d0bbda3ac","fightSeizeTimes":0,"pointElectTime":0,"troopActiveHeros":"rO0ABXVyABNbTGphdmEubGFuZy5TdHJpbmc7rdJW5+kde0cCAAB4cAAAAAd0AAhIZXJvLTI3N3QACEhlcm8tMjc2dAAHSGVyby0xMHQAB0hlcm8tMTF0AAhIZXJvLTI3OHQACEhlcm8tMjc5dAAHSGVyby0xMg==","recruitTalkLocked":false,"fightSeizeTime":0,"allianceExploitsDonateCoin":0,"mineNumNow":0,"level":15,"lastLastLoginTime":1397478864719,"protecedTime":0,"towerCD":0,"pGoodss":"com.xingcloud.service.item.OwnedItemCollection:5f3c6529-ce14-4770-af3a-746cbdc8eb51","power":0,"mailCheck":false,"heroRealizationGold":2,"pvpEnemyWinTimes":0,"status":0,"pChats":"com.xingcloud.service.item.OwnedItemCollection:7b4fca19-74ba-41a6-87a3-d335c0a0f990","chargeGoldSum":0,"pvpLastTime":0,"orangeCrystalNum":0,"heroFirstAdvanced":0,"msgCheck":false,"exp":0,"canGiveYellowHero":false,"cropTradingNum":0,"everyDayChargeSum":0,"heroTrainQueuesLocked":"rO0ABXVyAAJbWlePIDkUuF3iAgAAeHAAAAADAAAA","everyDayOnlinePrizeFinish":false,"heroFastTrainExp":3000,"popular":100,"forceCoinUseGold":2,"titleId":"Title-2","loginPrizeTimes":0,"mainTaskId":"MainTask-1","collectFreeSoldierNum":120,"canDrawSuperGiftBag":false,"pReceiveMails":"com.xingcloud.service.item.OwnedItemCollection:b331a68f-2b29-45c1-9633-66a268bc99b3","militaryMedals":0,"towerChallengeLevel":0,"prestige":290,"tradeGoldPrize":0,"ownedItems":"com.xingcloud.service.item.OwnedItemCollection:96997675-a7c1-4a7a-a6af-bc256e1faba6","productionGoodsTimes":0,"fightNoticeTime":0,"pItems":"com.xingcloud.service.item.OwnedItemCollection:ce8cc1d9-80ea-4e18-8526-152fdf56c8a9","canDrawPvePrize":false,"lastLoginSignTime":1397467007079,"towerTargetIndex":0,"isAllianceLeader":false,"lordUid":"","coin":611477,"loginSignTitalTimes":2,"gainCropLocked":false,"polity":0,"pInlayItems":"com.xingcloud.service.item.OwnedItemCollection:84291fa3-2e4e-47f0-b32b-f51180a39e66","forceProductionGoodsMoney":2,"activeLevel":0,"isDrawCodePrize":false,"pMines":"com.xingcloud.service.item.OwnedItemCollection:aa64a7c1-abeb-4ad3-869f-e8861c98766e","closedTask":false,"luoyangMaxTop":0,"collectFreeSoldierTimesMax":10,"pProfiles":"com.xingcloud.service.item.OwnedItemCollection:4804f24f-f907-4be4-808e-57e9abe3b7ea","pGMails":"com.xingcloud.service.item.OwnedItemCollection:8d54bdef-b323-416a-9416-aacaba6d749c","eventTimes":0,"pvpSearchCondition":150290,"instanceChallenge":"Instance-1"}';
    //$j = '{"uid":"46af6764-2c29-436a-a1f9-f22805861349","items":["game.service.item.cn.iggame.player.PVitality",{"7320184b-02c5-46d3-9cb7-f35254049e23":"7320184b-02c5-46d3-9cb7-f35254049e23","18630d36-3b74-459d-91e9-a20caa3c64cd":"18630d36-3b74-459d-91e9-a20caa3c64cd","916b834f-97e1-4db4-9754-e83533fa3e8d":"916b834f-97e1-4db4-9754-e83533fa3e8d","0d31121b-f45a-443b-8924-fa6348e35f2f":"0d31121b-f45a-443b-8924-fa6348e35f2f","336f1f79-e1e4-4fc4-9f83-dc5b4f641ee4":"336f1f79-e1e4-4fc4-9f83-dc5b4f641ee4","91d73455-f2a6-45a2-ae46-1e0241dfc30f":"91d73455-f2a6-45a2-ae46-1e0241dfc30f","fa98d95c-611b-40dc-b445-356072693cf5":"fa98d95c-611b-40dc-b445-356072693cf5","67f9b0e6-30f9-4aca-8ae3-52a986ec6f8b":"67f9b0e6-30f9-4aca-8ae3-52a986ec6f8b"}],"ownerProperty":"pVitalitys","className":"OwnedItemCollection"}';
    //$j = '{"uid":"aa64a7c1-abeb-4ad3-869f-e8861c98766e","items":["game.service.item.cn.iggame.player.PMine",{"93de6dfb-8ba8-45e4-898e-f261c1fa3700":"93de6dfb-8ba8-45e4-898e-f261c1fa3700"}],"ownerProperty":"pMines","className":"OwnedItemCollection"}';
    //$j = '{"uid":"46af6764-2c29-436a-a1f9-f22805861349","items":["game.service.item.cn.iggame.player.PVitality",{"7320184b-02c5-46d3-9cb7-f35254049e23":"7320184b-02c5-46d3-9cb7-f35254049e23","18630d36-3b74-459d-91e9-a20caa3c64cd":"18630d36-3b74-459d-91e9-a20caa3c64cd","916b834f-97e1-4db4-9754-e83533fa3e8d":"916b834f-97e1-4db4-9754-e83533fa3e8d","0d31121b-f45a-443b-8924-fa6348e35f2f":"0d31121b-f45a-443b-8924-fa6348e35f2f","336f1f79-e1e4-4fc4-9f83-dc5b4f641ee4":"336f1f79-e1e4-4fc4-9f83-dc5b4f641ee4","91d73455-f2a6-45a2-ae46-1e0241dfc30f":"91d73455-f2a6-45a2-ae46-1e0241dfc30f","fa98d95c-611b-40dc-b445-356072693cf5":"fa98d95c-611b-40dc-b445-356072693cf5","67f9b0e6-30f9-4aca-8ae3-52a986ec6f8b":"67f9b0e6-30f9-4aca-8ae3-52a986ec6f8b"}],"ownerProperty":"pVitalitys","className":"OwnedItemCollection"}';
    //$j = '{"uid":"8a52e61b-6edf-4699-a3e6-1184aa0e85ce","ownerId":"5e0c834e-06fd-49c0-881c-af0d0bbda3ac","normalatk":108,"tacdef":60,"equips":"rO0ABXVyABNbTGphdmEubGFuZy5TdHJpbmc7rdJW5+kde0cCAAB4cAAAAAd0AABxAH4AAnEAfgACcQB+AAJxAH4AAnEAfgACcQB+AAI=","baseForce":67.0,"nextUpgradeLevel":50,"armyTierMax":0,"expMax":3600,"armyId":"Army-13","forceGrow":1.8,"level":6,"trainFinishTime":1397230333913,"ownerProperty":"pHeros","magicatk":108,"name":"Trình Viễn Chí","baseIntel":49.0,"command":70.0,"isAutoAdvanced":false,"className":"PHero","magicdef":60,"beatback":0,"icon":"wjtx_chengyuanzhi.png","tacatk":108,"teachSoldierMaxAdd":0,"normaldef":60,"intelGrow":1.3,"itemId":"Hero-9","nextTransferLevel":15,"isTraining":false,"exp":1900,"soldier":560,"skill":"Skill-38","isEmploied":true,"trainBeginTime":1397227946499,"crit":0,"trainLevel":0,"baseCommand":70.0,"commandGrow":1.8,"intel":49.0,"soldierMax":560,"force":67.0,"decrease":0,"upgradeTimes":0}';
    //$j = '{"uid":"90c1a6f6-f655-40aa-859b-1345176d2412","goodsId":"Goods-3","level":2,"times":3,"income":40975,"ownerProperty":"pGoods","number":11,"className":"PGoods","itemId":"Goods-3"}';
    //$j = '{"visible":1,"partId":6,"id":"Equip-347","dbMoney":220,"saleType":0,"name":"Viêm Ngọc Bích","money":220,"cnname":"炎玉璧","className":"ShopEquip","gold":220,"end":0,"beatback":0,"limit":55,"icon":"tb_baowu_hong6.png","mainGrow":0,"coinGrow":0,"sellMax":99999,"coin":35000,"sgrow":31,"discount":10,"begin":0,"mainBase":5,"soldier":1008,"color":"红","enhancedTime":1000,"crit":0,"coinBase":0,"sellNum":1,"decrease":0,"buyLimit":false}';
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
    $levelText = GMText(array('label' => 'Level', 'name' => 'level', 'value' => $_POST['level'], 'id' => 'level'));
    $Button = GMButton(array('button' => array(
        array('name' => 'btnSubmit', 'type' => 'submit', 'id' => 'btnSubmit', 'value' => 'Search'),
        )));
    
      
    //$content = "<br>".$serverDropDown.$levelText.$Button;
	$content = "<br>".$serverDropDown.$Button;
    $xhtml = GMGenView(array('content' => $content, 'action' => base_url('?control=game&func=infouslgi'), 'method' => 'POST', 'legend' => 'FORM CHART USER LOGIN'));
    echo $xhtml;
    
   
?>
<style>
#fountainG{
position:relative;
width:240px;
height:29px;
margin: 10px auto;
}

.fountainG{
position:absolute;
top:0;
background-color:#155BB0;
width:29px;
height:29px;
-moz-animation-name:bounce_fountainG;
-moz-animation-duration:1.3s;
-moz-animation-iteration-count:infinite;
-moz-animation-direction:linear;
-moz-transform:scale(.3);
-moz-border-radius:19px;
-webkit-animation-name:bounce_fountainG;
-webkit-animation-duration:1.3s;
-webkit-animation-iteration-count:infinite;
-webkit-animation-direction:linear;
-webkit-transform:scale(.3);
-webkit-border-radius:19px;
-ms-animation-name:bounce_fountainG;
-ms-animation-duration:1.3s;
-ms-animation-iteration-count:infinite;
-ms-animation-direction:linear;
-ms-transform:scale(.3);
-ms-border-radius:19px;
-o-animation-name:bounce_fountainG;
-o-animation-duration:1.3s;
-o-animation-iteration-count:infinite;
-o-animation-direction:linear;
-o-transform:scale(.3);
-o-border-radius:19px;
animation-name:bounce_fountainG;
animation-duration:1.3s;
animation-iteration-count:infinite;
animation-direction:linear;
transform:scale(.3);
border-radius:19px;
}

#fountainG_1{
left:0;
-moz-animation-delay:0.52s;
-webkit-animation-delay:0.52s;
-ms-animation-delay:0.52s;
-o-animation-delay:0.52s;
animation-delay:0.52s;
}

#fountainG_2{
left:30px;
-moz-animation-delay:0.65s;
-webkit-animation-delay:0.65s;
-ms-animation-delay:0.65s;
-o-animation-delay:0.65s;
animation-delay:0.65s;
}

#fountainG_3{
left:60px;
-moz-animation-delay:0.78s;
-webkit-animation-delay:0.78s;
-ms-animation-delay:0.78s;
-o-animation-delay:0.78s;
animation-delay:0.78s;
}

#fountainG_4{
left:90px;
-moz-animation-delay:0.91s;
-webkit-animation-delay:0.91s;
-ms-animation-delay:0.91s;
-o-animation-delay:0.91s;
animation-delay:0.91s;
}

#fountainG_5{
left:120px;
-moz-animation-delay:1.04s;
-webkit-animation-delay:1.04s;
-ms-animation-delay:1.04s;
-o-animation-delay:1.04s;
animation-delay:1.04s;
}

#fountainG_6{
left:150px;
-moz-animation-delay:1.17s;
-webkit-animation-delay:1.17s;
-ms-animation-delay:1.17s;
-o-animation-delay:1.17s;
animation-delay:1.17s;
}

#fountainG_7{
left:180px;
-moz-animation-delay:1.3s;
-webkit-animation-delay:1.3s;
-ms-animation-delay:1.3s;
-o-animation-delay:1.3s;
animation-delay:1.3s;
}

#fountainG_8{
left:210px;
-moz-animation-delay:1.43s;
-webkit-animation-delay:1.43s;
-ms-animation-delay:1.43s;
-o-animation-delay:1.43s;
animation-delay:1.43s;
}

@-moz-keyframes bounce_fountainG{
0%{
-moz-transform:scale(1);
background-color:#155BB0;
}

100%{
-moz-transform:scale(.3);
background-color:#FFFFFF;
}

}

@-webkit-keyframes bounce_fountainG{
0%{
-webkit-transform:scale(1);
background-color:#155BB0;
}

100%{
-webkit-transform:scale(.3);
background-color:#FFFFFF;
}

}

@-ms-keyframes bounce_fountainG{
0%{
-ms-transform:scale(1);
background-color:#155BB0;
}

100%{
-ms-transform:scale(.3);
background-color:#FFFFFF;
}

}

@-o-keyframes bounce_fountainG{
0%{
-o-transform:scale(1);
background-color:#155BB0;
}

100%{
-o-transform:scale(.3);
background-color:#FFFFFF;
}

}

@keyframes bounce_fountainG{
0%{
transform:scale(1);
background-color:#155BB0;
}

100%{
transform:scale(.3);
background-color:#FFFFFF;
}

}

</style>
    <!--<div id="html1" style="margin-top:20px; margin-left:20px; width:95%;"></div>
    <div id="chart2" style="margin-top:20px; margin-left:20px; width:95%; height:400px;"></div>-->
    <div id="chart1" style="margin-top:20px; margin-left:20px; width:95%; height:400px;">
		<div id="fountainG">
		<div id="fountainG_1" class="fountainG">
		</div>
		<div id="fountainG_2" class="fountainG">
		</div>
		<div id="fountainG_3" class="fountainG">
		</div>
		<div id="fountainG_4" class="fountainG">
		</div>
		<div id="fountainG_5" class="fountainG">
		</div>
		<div id="fountainG_6" class="fountainG">
		</div>
		<div id="fountainG_7" class="fountainG">
		</div>
		<div id="fountainG_8" class="fountainG">
		</div>
		</div>
	</div>
    
</div>
<script>
    $(document).ready(function() {
    $("#level").keydown(function(event) {
    	// Allow only backspace and delete
        if ( event.keyCode == 46 || event.keyCode == 8 ) {
    		// let it happen, don't do anything
    	}
    	else {
    		// Ensure that it is a number and stop the keypress
    		if ((event.keyCode < 48 || event.keyCode > 57) &&  (event.keyCode < 96 || event.keyCode > 105)) {
    			event.preventDefault();	
    		}	
    	}
    });
    
      
   PAGE.handleLoadQuit();
   
   $("#btnSubmit").trigger("click");
   
});
 
var PAGE = {
    AJAX_URL_DATA: '<?php echo base_url('?control=game&func=loaddata') ?>',
    AJAX_URL_QUIT: '<?php echo base_url('?control=game&func=loadquit') ?>',
    handleLoadQuit: function(){
        $("#btnSubmit").click(function(e){
            e.preventDefault();
            var server = $("#server").val();
            var level = $("#level").val();
           $.ajax({
                type: "POST",
                dataType: 'json',
                url: PAGE.AJAX_URL_QUIT,
                data: {server:server, level: level},
                //beforeSend: startLoading,
                //complete: topLoading,
                success: PAGE.callbackQuit
                //complete: loaddata
                });

           
        });
    },
    callback: function(response){
        var data_y = response.data_y;
        var data_x = response.data_x;
        $('#chart1').highcharts({
            title: {
                text: 'Biểu đồ thể hiện lượng login theo ngày (30 ngày gần nhất)',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                //categories: ['2014-01-01','2014-01-02','2014-01-03']
                categories: data_x,
                labels: {
                    rotation: -45,
                    align: 'right',
                },
            },
            yAxis: {
                title: {
                    text: 'Số user'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' Lần'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'LOGIN',
                data: data_y,
                color: '#FF00FF',
                dashStyle: 'ShortDash',
                lineWidth: 1,
            }
            ]
        });
	
        
    },
    handleLoadData: function(){
        var server = $("#server").val();
        var level = $("#level").val();
        $.ajax({
             type: "POST",
             dataType: 'json',
             url: PAGE.AJAX_URL_DATA,
             data: {server:server, level: level},
             //beforeSend: startLoading,
             //complete: topLoading,
             success: PAGE.callback
             //complete: loaddata
             });
    },
    callbackQuit: function(response){
        var data_y7 = response.data_y7;
        var data_y30 = response.data_y30;
        var data_x = response.data_x;
        var data_html = response.data_html;
        
        //$("#html1").html(data_html);
        
        /*
        $('#chart2').highcharts({
            title: {
                text: 'Biểu đồ thể hiện Quit7, Quit30 theo level',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: data_x,
                labels: {
                    rotation: -45,
                    align: 'right',
                },
            },
            yAxis: {
                title: {
                    text: 'Số lần Login'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' Lần'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Quit 7',
                data: data_y7
            }, {
                name: 'Quit 30',
                data: data_y30
            }]
        });
		*/
        
        PAGE.handleLoadData();
    }
            
     
};

</script>
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
 

