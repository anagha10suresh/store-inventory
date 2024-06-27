-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2024 at 06:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
CREATE TABLE IF NOT EXISTS consumables (
    GIRNo VARCHAR(255),
    Date DATE,
    SupplierName VARCHAR(255),
    SlNo INT,
    Description VARCHAR(255),
    Quantity INT,
    EachRupees DECIMAL(10,2),
    TotalRupees DECIMAL(10,2),
    IndentSlNo INT,
    IndentNo VARCHAR(255),
    IndentDate DATE,
    IndentingOfficialName VARCHAR(255),
    LabSection VARCHAR(255),
    Received INT,
    Issued INT,
    Balance INT,
    ImageFilePath VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS furniture (
    GIRNo VARCHAR(255),
    Date DATE,
    SupplierName VARCHAR(255),
    SlNo INT,
    Description VARCHAR(255),
    Quantity INT,
    EachRupees DECIMAL(10,2),
    TotalRupees DECIMAL(10,2),
    IndentSlNo INT,
    IndentNo VARCHAR(255),
    IndentDate DATE,
    IndentingOfficialName VARCHAR(255),
    LabSection VARCHAR(255),
    Received INT,
    Issued INT,
    Balance INT,
    ImageFilePath VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS strive (
    GIRNo VARCHAR(255),
    Date DATE,
    SupplierName VARCHAR(255),
    SlNo INT,
    Description VARCHAR(255),
    Quantity INT,
    EachRupees DECIMAL(10,2),
    TotalRupees DECIMAL(10,2),
    IndentSlNo INT,
    IndentNo VARCHAR(255),
    IndentDate DATE,
    IndentingOfficialName VARCHAR(255),
    LabSection VARCHAR(255),
    Received INT,
    Issued INT,
    Balance INT,
    ImageFilePath VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS hostel (
    GIRNo VARCHAR(255),
    Date DATE,
    SupplierName VARCHAR(255),
    SlNo INT,
    Description VARCHAR(255),
    Quantity INT,
    EachRupees DECIMAL(10,2),
    TotalRupees DECIMAL(10,2),
    IndentSlNo INT,
    IndentNo VARCHAR(255),
    IndentDate DATE,
    IndentingOfficialName VARCHAR(255),
    LabSection VARCHAR(255),
    Received INT,
    Issued INT,
    Balance INT,
    ImageFilePath VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS machinery (
    GIRNo VARCHAR(255),
    Date DATE,
    SupplierName VARCHAR(255),
    SlNo INT,
    Description VARCHAR(255),
    Quantity INT,
    EachRupees DECIMAL(10,2),
    TotalRupees DECIMAL(10,2),
    IndentSlNo INT,
    IndentNo VARCHAR(255),
    IndentDate DATE,
    IndentingOfficialName VARCHAR(255),
    LabSection VARCHAR(255),
    Received INT,
    Issued INT,
    Balance INT,
    ImageFilePath VARCHAR(255)
);
CREATE TABLE condemned (
    SlNo INT AUTO_INCREMENT PRIMARY KEY,
    Date DATE NOT NULL,
    ItemName VARCHAR(255) NOT NULL,
    ItemCondemned VARCHAR(255) NOT NULL,
    DateOfPurchase DATE NOT NULL,
    DSRNo VARCHAR(50) NOT NULL
);
CREATE TABLE IF NOT EXISTS goods_inward_register (
    Sl_No INT AUTO_INCREMENT PRIMARY KEY,
    Supplier_Name VARCHAR(255),
    Supplier_Address VARCHAR(255),
    PO_Number VARCHAR(255),
    Date_of_PO DATE,
    Item_Description VARCHAR(255),
    Qty_Record INT,
    Bin_Card_No VARCHAR(255),
    Stock_Ledger_No VARCHAR(255),
    Remarks VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS issueregister (
    sl_no INT AUTO_INCREMENT PRIMARY KEY,
    date DATE,
    item_name VARCHAR(255),
    trade VARCHAR(255),
    quantity INT,
    date_of_indent DATE,
    date_of_return DATE,
    amount DECIMAL(10,2)
);
CREATE TABLE IF NOT EXISTS sar_entry (
    Sl_No INT AUTO_INCREMENT PRIMARY KEY,
    Date DATE,
    Seller_Details VARCHAR(255),
    Item_Description VARCHAR(255),
    Quantity INT,
    Invoice_Details VARCHAR(255),
    Store_Arrival_Date DATE,
    Trade VARCHAR(255),
    Remarks VARCHAR(255)
);
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255),
    password VARCHAR(255)
);

INSERT INTO users (id, email, password) VALUES (1, 'admin123@gmail.com', '#admin123');

