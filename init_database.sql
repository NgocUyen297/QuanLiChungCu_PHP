-- Step 1
CREATE DATABASE NiceApartment;

-- Step 2 -- DDL
USE NiceApartment;
CREATE TABLE NhanVien (
    id int AUTO_INCREMENT PRIMARY KEY,
    firstname CHARACTER(20) NOT NULL,
    lastname CHARACTER(50) NOT NULL,
    username CHARACTER(30) NOT NULL,
    password CHARACTER(30) NOT NULL,
    phoneNumber CHARACTER(11),
    hometown CHARACTER(30),
    role ENUM('Manager', 'Accountant') NOT NULL
);

CREATE TABLE QuyDinh (
    id int AUTO_INCREMENT PRIMARY KEY,
    date DATETIME NOT NULL,
    electronicFee float NOT NULL,
    waterFee float NOT NULL,
    parkFee float NOT NULL,
    managementFee float NOT NULL,
    NhanVienId int NOT NULL,
    FOREIGN KEY (NhanVienId) REFERENCES NhanVien(id)
);

CREATE TABLE ThongTinCanHo(
    id int AUTO_INCREMENT PRIMARY KEY,
    description CHARACTER(255),
    rooms int NOT NULL,
    upstairs BOOLEAN NOT NULL,
    restroom float NOT NULL,
    inArea float NOT NULL,
    createdBy int NOT NULL,
    FOREIGN KEY (createdBy) REFERENCES NhanVien(id)
);

CREATE TABLE ThongTinHo (
    id int AUTO_INCREMENT PRIMARY KEY,
    apartmentNo int NOT NULL,
    ownerFirstName CHARACTER(20) NOT NULL,
    ownerLastName CHARACTER(50),
    ownerPhoneNumber CHARACTER(11) NOT NULL,
    ownerIdentityNumber int NOT NULL,
    createdBy int,
    FOREIGN KEY (createdBy) REFERENCES NhanVien(id),
    FOREIGN KEY (apartmentNo) REFERENCES ThongTinCanHo(id)
);

CREATE TABLE HopDong (
    id int AUTO_INCREMENT PRIMARY KEY,
    path CHARACTER(255) NOT NULL,
    date DATETIME NOT NULL,
    apartmentNo int NOT NULL,
    createdBy int NOT NULL,
    FOREIGN KEY (createdBy) REFERENCES NhanVien(id),
    FOREIGN KEY (apartmentNo) REFERENCES ThongTinCanHo(id)
);

CREATE TABLE NhanKhau(
    id int AUTO_INCREMENT PRIMARY KEY,
    firstname CHARACTER(20) NOT NULL,
    lastname CHARACTER(30) NOT NULL,
    identityNumber int NULL,
    ownerIndex int NOT NULL,
    FOREIGN KEY (ownerIndex) REFERENCES ThongTinHo(id)
);

CREATE TABLE ThongTinSuCo(
    id int AUTO_INCREMENT PRIMARY KEY,
    description CHARACTER(255) NOT NULL,
    date datetime NOT NULL,
    apartmentNo int NOT NULL,
    createdBy int,
    FOREIGN KEY (createdBy) REFERENCES NhanVien(id),
    FOREIGN KEY (apartmentNo) REFERENCES ThongTinCanHo(id)
);

CREATE TABLE HoaDon(
    id int AUTO_INCREMENT PRIMARY KEY,
    description CHARACTER(255),
    createdDate datetime NOT NULL,
    path CHARACTER(255) NOT NULL,
    moneyIn float NOT NULL,
    createdBy int NOT NULL,
    regulationId int NULL,
    whoPay int,
    errors int,
    FOREIGN KEY (createdBy) REFERENCES NhanVien(id),
    FOREIGN KEY (regulationId) REFERENCES QuyDinh(id)
);

CREATE TABLE ThongTinHoaDon(
    id int AUTO_INCREMENT PRIMARY KEY,
    eletricity float,
    water float,
    internet float,
    paid TINYINT(1),
    linkId int,
    FOREIGN KEY (linkId) REFERENCES HoaDon(id)
);

CREATE TABLE DoiTac(
    id int AUTO_INCREMENT PRIMARY KEY,
    companyName CHARACTER(100) NOT NULL,
    hotline CHARACTER(20),
    address CHARACTER(100)
);

-- Step 3 DML

-- Table NhanVien
USE NiceApartment;
INSERT INTO NhanVien VALUES 
('1', 'Thanh', 'Nguyen Van', 'nguyenvanthanh', '123', '0728421471', 'TP.HCM', 1);
INSERT INTO NhanVien VALUES 
('2', 'Uyen', 'Nguyen Thi Ngoc', 'ngocuyen', '123', '0728345371', 'Binh Thuan', 2);
INSERT INTO NhanVien VALUES 
('3', 'Tien', 'Nguyen Minh', 'minhtien', '123', '0722351471', 'Binh Duong', 1);

-- Table ThongTinCanHo
INSERT INTO ThongTinCanHo VALUES
('1', "Can ho so 1", 3, 1, 2.5, 100, 1);
INSERT INTO ThongTinCanHo VALUES
('2', "Can ho so 2", 2, 1, 1.5, 100, 1);
INSERT INTO ThongTinCanHo VALUES
('3', "Can ho so 3", 4, 1, 3.5, 120, 1);
INSERT INTO ThongTinCanHo VALUES
('4', "Can ho so 4", 5, 1, 3.5, 145, 1);
INSERT INTO ThongTinCanHo VALUES
('5', "Can ho so 5", 3, 1, 2.5, 100, 1);

-- Table ThongTinHo
INSERT INTO ThongTinHo VALUES
('1', 1, 'Thanh', 'Nguyen Loi', '0712726174', '2781672911271', 1);
INSERT INTO ThongTinHo VALUES
('2', 2, 'Uyen', 'Tran Nha', '0712734574', '2412742911271', 1);
INSERT INTO ThongTinHo VALUES
('3', 3, 'Hoi', 'Vo Khac', '0712341274', '2734623528271', 1);
INSERT INTO ThongTinHo VALUES
('4', 4, 'Cho', 'Le Thang', '0922726174', '2451672911271', 1);

-- Table Hop Dong
INSERT INTO HopDong VALUES 
('1', '/store/example.pdf', '2020/01/01 15:20:22', 1, 1);
INSERT INTO HopDong VALUES 
('2', '/store/example.pdf', '2020/01/01 15:20:22', 4, 1);
INSERT INTO HopDong VALUES 
('3', '/store/example.pdf', '2020/01/01 15:20:22', 2, 1);
INSERT INTO HopDong VALUES 
('4', '/store/example.pdf', '2020/01/01 15:20:22', 3, 1);

-- Table NhanKhau
INSERT INTO NhanKhau VALUES
('1', 'Hang', 'Nguyen Thi Mong', '214612841178', 1);
INSERT INTO NhanKhau VALUES
('2', 'Be', 'Nguyen Van', NULL, 1);
INSERT INTO NhanKhau VALUES
('3', 'Anh', 'Nguyen Thi Kieu', NULL, 1);
INSERT INTO NhanKhau VALUES
('4', 'Nhu', 'Ha Trong', '223512561178', 2);
INSERT INTO NhanKhau VALUES
('5', 'Tam', 'Ha Nguyen Thanh', NULL, 2);
INSERT INTO NhanKhau VALUES
('6', 'An', 'Nguyen Thanh', NULL, 2);
INSERT INTO NhanKhau VALUES
('7', 'Tra', 'Hanh Thi', '212342823538', 3);

-- Table ThongTinSuCo
INSERT INTO ThongTinSuCo VALUES
('1', 'Nut vach cap do 1', '2021/01/02 00:00:00', 1, 1);

-- Table DoiTac
INSERT INTO DoiTac VALUES
('1', 'Cong ty cung cap dien EVN', '19001276727', '179 Duong 30/4, Quan 3, TPHCM');
INSERT INTO DoiTac VALUES
('2', 'Cong ty cung cap nuoc Biwase', '19002348788', '899/28 Ha Huy Giap, Quan 7, TPHCM');
INSERT INTO DoiTac VALUES
('3', 'Cong ty cung cap dich vu Internet Viettel', '1900588882', '123 Duong Quang Ham, Quan Go Vap, TPHCM');

-- Table QuyDinh
INSERT INTO QuyDinh VALUES
('1', '2020/01/01 00:00:00', 3.500, 15.000, 100.000, 500.000, 1);
INSERT INTO QuyDinh VALUES
('2', '2021/01/01 00:00:00', 3.550, 15.300, 90.000, 515.345, 1);

-- Table HoaDon
INSERT INTO HoaDon VALUES
('1', 'khach 1', '2021/01/01 09:00:00', 'store_checkout/example.pdf', 0, 2, 2, NULL, NULL);
INSERT INTO HoaDon VALUES
('2', 'khach 2', '2021/01/01 09:00:00', 'store_checkout/example.pdf', 0, 2, 2, NULL, NULL);
INSERT INTO HoaDon VALUES
('3', 'tien dien', '2021/01/01 09:00:00', 'store_checkout/example.pdf', -1550000.0, 2, 2, NULL, NULL);

-- Table ThongTinHoaDon
INSERT INTO ThongTinHoaDon VALUES
('1', 120.0, 5.0, 2, 0, 1);
INSERT INTO ThongTinHoaDon VALUES
('2', 135.0, 4.5, 1, 0, 2);
INSERT INTO ThongTinHoaDon VALUES
('3', 555.0, NULL, NULL, 1, 3);