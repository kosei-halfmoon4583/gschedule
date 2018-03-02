-- MySQL dump 10.13  Distrib 5.1.42, for Win32 (ia32)
--
-- Host: localhost	  Database: gschedule
-- ------------------------------------------------------
-- Server version	5.1.42-community

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounttb`
--

DROP TABLE IF EXISTS `accounttb`;
/*!40101 SET @saved_cs_client	  = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounttb` (
  `userid` varchar(8) NOT NULL,
  `passwd` varchar(8) NOT NULL,
  `jpname` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `notify` tinyint(4) DEFAULT '0',
  `admin` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounttb`
--

LOCK TABLES `accounttb` WRITE;
/*!40000 ALTER TABLE `accounttb` DISABLE KEYS */;
INSERT INTO `accounttb` VALUES ('guest1','guest1','ゲストユーザ11','guest1@examples.co.jp',0,0),('guest2','guest2','ゲストユーザ22','guest2@examples.co.jp',0,1),('guest3','guest3','ゲストユーザ33','guest3@examples.com',0,3),('guest4','guest4','ゲストユーザ44','guest4@examples.com',0,3),('guest5','guest5','ゲストユーザ567','guest5@examples.com',0,4),('katagiri','katagiri','片桐俊亮','suke@sket.co.jp',0,4),('kikuchi','kikuchi','菊池孝治','kikuchi@kiccoo.co.jp',0,2),('kosei','kosei458','綿貫晃誠','kosei4583@gmail.com',0,2),('morita','morita','森田健太郎','kmorita@greentree.co.jp',1,1),('satoh','hideo','佐藤秀雄','h-satohi@gmail.com',0,4),('shimizu','shimizu','清水晃市','kshimizu@gmail.com',0,0),('suzuki','suzuki','鈴木一郎','i-suzuki@gmail.com',0,2),('user1','user1','ユーザ１','user1@examples.co.jp',0,2),('user2','user2','ユーザ２','user2@examples.co.jp',0,0),('user3','user3','ユーザ３','user3@examples.com',0,3),('user4','user4','User4','user4@examples.com',0,2),('user5','user5','User5','user5@examples.com',0,2),('watako','amiw3911','綿貫明美','pa.let2696@gmail.com',0,0),('watanuki','naow4583','綿貫直志','kosei.halfmoon@gmail.com',1,1);
/*!40000 ALTER TABLE `accounttb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kwordtb`
--

DROP TABLE IF EXISTS `kwordtb`;
/*!40101 SET @saved_cs_client	  = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kwordtb` (
  `kid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kwd` varchar(255) DEFAULT NULL,
  `kurl` varchar(255) DEFAULT NULL,
  `kusr` varchar(40) DEFAULT NULL,
  `kemail` varchar(80) DEFAULT NULL,
  `kdate` date NOT NULL,
  `kcont` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`kid`),
  KEY `key1` (`kdate`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kwordtb`
--

LOCK TABLES `kwordtb` WRITE;
/*!40000 ALTER TABLE `kwordtb` DISABLE KEYS */;
INSERT INTO `kwordtb` VALUES (1,'キーワード１','http://www.testsite.com/','綿貫直志','pa.let2696@gmail.com','2011-02-15','test'),(2,'宴会','http://www.examples.com/','森田健太郎','pa.let2696@gmail.com','2011-02-15','test'),(3,'飲み会','http://gnavi.com/','綿貫晃誠','kosei.halfmoon@gmail.com','2011-02-09','test comment 2'),(9,'送別会','http://www.gnavi.co.jp/','綿貫直志','n-watanuki@bb.softbank.co.jp','2011-02-16','備考１'),(10,'歓迎会','http://www.gnavi.co.jp/','太田泰司','user11@bb.softbank.co.jp','2011-02-16','備考2'),(11,'出張','http://kosei-halfmoon.blogdns.net/gs/','原　辰則','hara@bb.softbank.co.jp','2011-02-16','備考５'),(12,'営業会議','http://kosei-halfmoon.blogdns.net/blog','ゲストユーザ１','user12@gmail.com','2011-02-16','備考１２'),(13,'接待','http://gnavi.co.jp','ユーザ13','user13@gmail.com','2011-02-16','備考１３'),(14,'談合','http://www.dangoo.net/','談合太郎','dangoo@examples.co.jp','2011-02-17','備考１４'),(15,'テスト','http://www.visible.co.jp/','Visible test.','visible@errorcheck.jp','2011-02-17',''),(16,'keyword16','http://www.regexp.jp/','RegExp','regexp@examples.com','2011-02-17',''),(17,'ヤフー','http://www.yahoo.co.jp/','yahoo','u-as@yahoo.co.jp','2011-02-17',''),(18,'件数チェック','http://www.count.co.jp/','count','count@examples.com','2011-02-17','備考１５'),(19,'受託','http://amazon.com/','user16','user16@examples.co.jp','2011-02-17','備考１６'),(20,'debug','http://debug.net/','user17','user17@debug.com','2011-02-18',''),(21,'FireBug','http://www.firebug.com/','user18','user18@firebug.com','2011-02-18','');
/*!40000 ALTER TABLE `kwordtb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schdtb`
--

DROP TABLE IF EXISTS `schdtb`;
/*!40101 SET @saved_cs_client	  = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schdtb` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sdate` date NOT NULL,
  `sstime` varchar(4) NOT NULL,
  `setime` varchar(4) DEFAULT NULL,
  `cont1` varchar(30) NOT NULL,
  `cont2` varchar(80) DEFAULT NULL,
  `suserid` varchar(8) NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `key1` (`sdate`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schdtb`
--

LOCK TABLES `schdtb` WRITE;
/*!40000 ALTER TABLE `schdtb` DISABLE KEYS */;
INSERT INTO `schdtb` VALUES (6,'2007-12-12','1600','1700','test schedule3','Schesule No3','watanuki'),(9,'2007-12-27','1135','1135','test','test schedule9','watanuki'),(10,'2007-12-28','1140','1240','test8','test schedule 10','watanuki'),(12,'2007-12-28','1600','1700','test 12','test schedule 12','watanuki'),(13,'2007-12-28','1730','1900','test','test delete!','watanuki'),(14,'2007-12-03','1825','1825','schedule1','test schedule','watanuki'),(15,'2008-01-21','1413','1413','multi entry test1','test1','watanuki'),(16,'2008-01-21','1413','1413','another entry!','test2','morita'),(17,'2008-01-21','1531','1531','multi entry2','test3','watanuki'),(19,'2008-01-22','1600','1700','Program','wekUreg.php','watanuki'),(20,'2008-01-23','1600','1700','MDS System Platform','How should we do the MDS System platform?','watanuki'),(21,'2008-01-23','1000','1100','Private Schedule','Private issue','watanuki'),(22,'2008-01-24','1100','1200','Startforce ','Startforce comming','watanuki'),(23,'2008-02-06','1600','1700','Program Modified','Program Modified at Schedule Entry Module.','watanuki'),(24,'2008-02-07','1100','1230','Sakkam MTG','Sakkam coming at our office.(For Test)','watanuki'),(25,'2008-02-08','1100','1230','Sakkam Co.Ltd','Sakkam regular MTG','watanuki'),(26,'2008-02-07','1900','2000','test schedule234-5','test schedule 13','watanuki'),(27,'2008-02-06','2000','2200','Task003','test schedule 14','watanuki'),(28,'2008-02-18','0930','1900','Business trip to Alibaba','Business trip to Alibaba.(Day 1)','watanuki'),(29,'2008-02-19','0900','1745','Business MTG','Business MTG. (Day 2)','watanuki'),(30,'2008-02-20','1315','1705','Leave Alibaba to Japan.','Leave Alibaba to Japan.','watanuki'),(37,'2010-01-26','2020','2020','test','test schedule 10','watanuki'),(40,'2010-02-04','1500','1600','Encodingテスト','I do not understand encoding of the PHP.','watanuki'),(41,'2010-02-04','1600','1700','文字化け解消','17:12頃、Schedule Management Systemは文字化けが解消された。','watanuki'),(42,'2010-02-04','1900','2000','新規ユーザ','新規ユーザで登録してみる','kosei2'),(44,'2010-02-05','1400','1440','文字化け問題','JSONの文字化けは、mb_convert_encodingを利用して解決した。','watanuki'),(45,'2010-02-08','0930','1200','資料作成','業務連絡会議資料作成','watanuki'),(46,'2010-02-09','1030','1130','入力テスト','長いメッセージを登録するテスト','watanuki'),(47,'2010-02-10','1300','1700','プログラム修正','「予定あり」ではなくアイコン（えんぴつ）を表示する','watanuki'),(48,'2010-02-13','1400','1700','平野クン結婚式','平野クン結婚式出席','watanuki'),(49,'2010-02-24','1300','1500','情ｼｽUNIT長会議','情ｼｽ本部　UNIT長会議参加','watanuki'),(50,'2010-02-16','0900','1800','テストプログラミング','Ext.grid.EditorGridPanel プログラミング検証です！','watanuki'),(51,'2010-02-18','1300','1445','予定','文字コードチェック','watanuki'),(52,'2010-02-26','1400','1500','CTC様来社','DBPoolシステム運用内製化　打合せ','watanuki'),(53,'2010-03-03','0900','1800','出張です','出張でんがな。。。','watanuki'),(54,'2010-03-04','1705','1705','入力テスト','明日から出社しますよ。','watanuki'),(55,'2010-03-05','1700','1800','テスト中です。','システムテストするべし。','watanuki'),(57,'2010-03-10','0930','1100','部課長会議','2010年2月度　月次報告','watanuki'),(58,'2010-03-24','1500','1600','BigMachines','BigMachines Demo','morita'),(59,'2010-03-11','1600','1700','テストでござる！','テストするでござる！！','watanuki'),(60,'2010-03-09','1830','2130','Phil Dinner.','会食（Phil, 荒川さん,　鈴木さん,　近藤さん）','watanuki'),(61,'2010-03-12','0900','1200','課定例会議','マスターメンテナンスPGM開発レビュー','watanuki'),(63,'2010-03-15','1038','1038','キーワードテスト','東京出張です','watanuki'),(64,'2010-03-19','1638','1638','予定','9時出社','watanuki'),(65,'2010-03-19','1638','1638','出張','東京出張です、','watanuki'),(66,'2010-08-02','1342','1342','iPad Programming','Sencha Touch コーディング検証','watanuki'),(67,'2010-08-05','1546','1546','session変数','Session変数をプログラム間で引き渡す方法は？','watanuki'),(68,'2011-01-01','1615','1615','お正月','正月です！','watanuki'),(69,'2011-01-05','1615','1615','2011出社！','2011年、初出社日です。','watanuki'),(70,'2011-01-31','1451','1451','ヘッダー','[曜日]追加','watanuki'),(71,'2011-01-31','1800','1820','夕礼','C&Sシステム統括部、夕礼','watanuki'),(72,'2011-02-01','1300','1700','プログラミング','テストプログラミング','watanuki'),(73,'2011-02-05','1000','1130','晃誠お祝い','晃誠お祝い購入（品川AEON）','watanuki'),(74,'2011-02-05','1300','1430','AMPIO','AMPIOミッシングリンク取り付け','watanuki'),(75,'2011-02-04','1300','1700','ライブラリ化','テストプログラム・ライブラリ追加','watanuki'),(76,'2011-02-03','0930','1200','部内打合せ','部内打合せ実施（C-01会議室）','watanuki'),(77,'2011-02-08','1400','1430','New Table','New Table(kwordtb)　追加','watanuki'),(78,'2011-02-19','1000','1600','Charioホイール','HUBグリスアップ、玉当たり調整？','watanuki'),(79,'2011-02-21','1000','1745','CCNA Catchupコース１','CCNA講習受講','watanuki'),(80,'2011-02-22','1000','1745','CCNA Catchupコース２','CCNA講習受講','watanuki'),(81,'2011-02-20','1000','1200','ケミカル','ケミカル用品調査','watanuki');
/*!40000 ALTER TABLE `schdtb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todotb`
--

DROP TABLE IF EXISTS `todotb`;
/*!40101 SET @saved_cs_client	  = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todotb` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tdate` date NOT NULL,
  `todo` varchar(80) NOT NULL,
  `tuserid` varchar(8) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `key1` (`tdate`),
  KEY `key2` (`todo`(10))
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todotb`
--

LOCK TABLES `todotb` WRITE;
/*!40000 ALTER TABLE `todotb` DISABLE KEYS */;
INSERT INTO `todotb` VALUES (9,'2010-02-03','myJSON test for ExtJS Grid.','watanuki'),(10,'2010-02-18','ExtJS Grid TEST Program （UTF-8）','watanuki'),(11,'2010-02-18','mysql_query(\"SET NAMES ujis\",$conn);をコメントアウトします。','watanuki'),(12,'2010-02-18','ExtJS Character Code TEST for EUC-JP','watanuki'),(13,'2010-02-18','ExtJS Character Code TEST for UTF-8','watanuki'),(14,'2010-03-11','広告エリア（menu-ad）を加える','watanuki'),(15,'2010-03-17','再び、文字化けと闘う','watanuki'),(17,'2010-08-19','JSON調査継続','watanuki'),(24,'2011-02-08','明日は出張です','watanuki'),(25,'2011-02-15','出張','watanuki');
/*!40000 ALTER TABLE `todotb` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-02-24 15:52:53
