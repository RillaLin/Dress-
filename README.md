# Dress-
使用php連接MySQL模擬出一個服飾網拍店家整合平台。  

這個網頁是我在五專(台中科技大學-資訊應用)時小組分工的小專作品，我主要負責登入、搜尋排序、購物車等前端排版和連結MySQL資料庫的部分。  
因為是幾年前的作品，有部分檔案丟失，所以某些部分有點出錯，排版也不是很完美，我之後再改善調整。

# 影片Demo
Dress 瀏覽+購物車功能  
https://www.youtube.com/watch?v=GySPPtL0OpA&ab_channel=RillaLin  
  
Dress 功能列  
https://www.youtube.com/watch?v=VHGS0Pe5AB0&ab_channel=RillaLin  
  
Dress 後台管理  
https://youtu.be/V0IK8OOnn2g   

# PHP介紹
PHP語言是伺服器端(Server)執行的網頁，不像一般HTML網頁，只要單機下開啟檔案就可以檢視網頁，PHP必須先在伺服器端執行完後，再將結果傳至使用者端(Client)的瀏覽器中檢視結果，所以必須使用網站伺服器，且伺服器要支援PHP。  
  
 PHP語言的全名是(PHP: Hypertext Preprocessor)，和ASP、JSP等都是動態網頁開發語言，不過，PHP擁有跨平台的能力，無論是在Linux(最適合)、Unix、 Windows都可以執行運作，不像微軟 的ASP只能在Windows平台上執行，而且PHP是免費的，並可結合多種資料庫伺服器，如:MySQL、PostgreSQL、dBase、mSQL、Informix、ODBC、Oracle等。    

# SQL語法筆記
[系統後台]  
會員帳號管理  
SELECT * FROM members WHERE mid = “”;  
店家帳號管理  
SELECT * FROM stores WHERE sid = “” ;  
產品管理  
SELECT * FROM products WHERE pid = “”;  
銷售管理  
SELECT * FROM sales WHERE oid = “”;    

[系統前台-店家]  
管理帳號  
SELECT sname,simg,stxt,sphone FROM stores ;  

產品管理介面  
SELECT pname,pimg,pstyle,psize,paramount,pprice,pdate FROM sproducts;  

查詢  
SELECT pname,pimg,pstyle,psize,paramount,pprice,pdate FROM sproducts WHERE pname LIKE “%%”;  

[系統前台-會員]  

[首頁]  
當季新品  
SELECT sprodocts.pimg,stores.sname,sproducts.pname,sproducts.pprice FROM sproducts,stores ORDER BY sproducts.pdate DESC;    

熱銷新品  
SELECT sprodocts.pimg,stores.sname,sproducts.pname,sproducts.pprice FROM sproducts,stores,products ORDER BY sproducts.pdate DESC;    

促銷商品  
SELECT products.pimg,stores.simg,stores.sname,products.pname,products.pprice FROM products,stores WHERE psprice < poprice;    

關於店家  
SELECT simg,sname,stxt,sphone,semail FROM stores ORDER BY sname ASC;    

商品頁面  
SELECT sproducts.pname,sproducts.pimg,sproducts.pclass,sproducts.pstyle,  
sproducts.psize,sproducts.psprice,sproducts.poprice,suggests.wearpic,suggests.suggest FROM sproducts,suggests WHERE pname = "";    

新增產品至購物車  
INSERT sales (pname,pstyle,psize,oammount) VALUES ('','','','');    

會員專區  
SELECT sales.oid,sales.pname,sales.oamount,sales.total,members.mname,members.maccount FROM sales,members ;    

購物紀錄  
SELECT checkout.oid,checkout.cdate,sales.pname,sales.pstyle,sales.psize,sales.oamount,products.psprice FROM checkout,sales,products;    

修改會員帳號  
UPDATE dress SET mname =  '{$_POST['name']}' WHERE mid =  '{$_POST['mid']}'    

修改密碼  
UPDATE members SET mpsd = "";    

購物車  
SELECT pimg,pname,pstyle,psize,oamount,total FROM sales;    

結帳  
SELECT * FROM checkout;    

# MySOL資料庫
專案檔放置位置
![image](https://user-images.githubusercontent.com/72490355/160274441-3fa94263-f0a2-4841-a501-c20fe46350c2.png)  



