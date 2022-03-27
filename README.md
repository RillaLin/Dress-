# Dress-
使用php連接MySQL模擬出一個服飾網拍店家整合平台。  
是我在五專(台中科技大學-資訊應用)時小組分工的小專作品，我主要負責登入、搜尋排序、購物車等前端排版和連結MySQL資料庫的部分。  
因為是幾年前的作品，有部分檔案丟失，所以某些部分有點出錯，排版也不是很完美，我之後再改善調整。

# 影片Demo
Dress 瀏覽+購物車功能  
https://www.youtube.com/watch?v=GySPPtL0OpA&ab_channel=RillaLin  
  
Dress 功能列  
https://www.youtube.com/watch?v=VHGS0Pe5AB0&ab_channel=RillaLin  
  
Dress 後台管理  
https://youtu.be/V0IK8OOnn2g    

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

