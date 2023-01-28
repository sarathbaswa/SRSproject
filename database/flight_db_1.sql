
--
-- Database: `flight_db_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `airstation`
--

CREATE TABLE `airstation` (
  `code_name` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `city_name` varchar(20) NOT NULL,
  `state_name` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airstation`
--

INSERT INTO `airstation` (`code_name`, `name`, `city_name`, `state_name`, `country`) VALUES
('DAF', 'Dallas Fort Airport', 'Dallas', 'Texas', 'USA'),
('DAL', 'Dallas Field Airport', 'Dallas', 'Texas', 'USA'),
('LOS', 'Los Angeles Airport', 'Los Angeles', 'California', 'USA'),
('SAN', 'San Francisco ', 'San Fransciso', 'California', 'USA'),
('SEA', 'Seattle Airport', 'Seattle', 'Washington', 'USA');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `ID` int(11) NOT NULL,
  `book_time` datetime NOT NULL,
  `book_date` date NOT NULL,
  `flight_id` varchar(10) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `class_type` varchar(20) NOT NULL,
  `is_paid` int(1) DEFAULT 0,
  `pname` varchar(100) DEFAULT NULL,
  `page` int(11) DEFAULT NULL,
  `pgender` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--


-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `username` varchar(30) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `password` varchar(45) NOT NULL,
  `mileage` float DEFAULT NULL,
  `redeem` float DEFAULT NULL,
  `card_id` varchar(100) DEFAULT NULL,
  `card_type` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--


-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `passenger_id` varchar(100) NOT NULL,
  `comment` varchar(8092) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `passenger_id`, `comment`, `rating`) VALUES
(1, '', 'Great', 1),
(2, '', 'awesome', 1),
(3, '', 'Great', 7);

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `flight_id` varchar(20) NOT NULL,
  `airplane_id` varchar(10) NOT NULL,
  `dep_loc` varchar(10) NOT NULL,
  `dep_time` time NOT NULL,
  `arr_loc` varchar(10) NOT NULL,
  `arr_time` time NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `dep_date` varchar(100) DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `flight_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`flight_id`, `airplane_id`, `dep_loc`, `dep_time`, `arr_loc`, `arr_time`, `status`, `dep_date`, `distance`, `flight_type`) VALUES
('AB100', '1000', 'LOS', '08:35:00', 'SEA', '21:00:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB101', '2000', 'DAF', '04:35:00', 'LOS', '17:30:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB102', '1000', 'SEA', '03:40:00', 'DAF', '19:30:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB103', '2000', 'DAF', '17:35:00', 'SAN', '10:30:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB104', '1000', 'SAN', '10:30:00', 'DAF', '22:00:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB105', '2000', 'DAL', '14:00:00', 'SEA', '21:00:00', 'Delayed', '2022-11-13', 2000, 'domestic'),
('AB106', '1000', 'SEA', '21:00:00', 'DAL', '23:00:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB107', '1000', 'SAN', '13:00:00', 'SEA', '13:00:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB108', '2000', 'SEA', '15:00:00', 'SAN', '19:00:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB109', '1000', 'LOS', '21:00:00', 'DAF', '23:00:00', 'In Flight', '2022-11-13', 2000, 'domestic'),
('AB110', '2000', 'DAF', '11:00:00', 'SEA', '14:00:00', 'In Flight', '2022-11-13', 2000, 'domestic');

-- --------------------------------------------------------

--
-- Table structure for table `flight_company`
--

CREATE TABLE `flight_company` (
  `ID` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `company` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight_company`
--

INSERT INTO `flight_company` (`ID`, `type`, `company`) VALUES
('1000', 'qwee', 'Boeing'),
('2000', 'SQWE', 'Airbus');

-- --------------------------------------------------------

--
-- Table structure for table `flight_details`
--

CREATE TABLE `flight_details` (
  `flight_id` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flight_details`
--

INSERT INTO `flight_details` (`flight_id`, `name`, `capacity`, `price`) VALUES
('AB100', 'Economy', 75, 300),
('AB101', 'Economy', 75, 650),
('AB102', 'Economy', 75, 230),
('AB103', 'Economy', 75, 80),
('AB104', 'Economy', 75, 82),
('AB105', 'Economy', 75, 70),
('AB106', 'Economy', 75, 80),
('AB107', 'Economy', 75, 60),
('AB108', 'Economy', 75, 60),
('AB109', 'Economy', 75, 45),
('AB110', 'Economy', 75, 156);

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `place` varchar(200) NOT NULL,
  `room_count` int(11) NOT NULL,
  `star` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `place`, `room_count`, `star`, `price`) VALUES
(1, 'Blue Moon', 'San Fransisco', 20, 4, 200),
(2, 'Green Park', 'Seattle', 20, 4, 500),
(3, 'Great House', 'Dallas', 20, 3, 250),
(4, 'SLV Hotel', 'Seattle', 20, 5, 400),
(5, 'MRV Hotel', 'Los Angles', 20, 5, 300);

-- --------------------------------------------------------

--
-- Table structure for table `hotel_booking`
--

CREATE TABLE `hotel_booking` (
  `id` int(11) NOT NULL,
  `in_date` date DEFAULT NULL,
  `out_date` date DEFAULT NULL,
  `num_persons` int(11) DEFAULT NULL,
  `hid` int(11) DEFAULT NULL,
  `is_paid` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `book_time` timestamp(1) NULL DEFAULT NULL ON UPDATE current_timestamp(1),
  `num_rooms` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotel_booking`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `airstation`
--
ALTER TABLE `airstation`
  ADD PRIMARY KEY (`code_name`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`ID`,`flight_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`flight_id`);

--
-- Indexes for table `flight_company`
--
ALTER TABLE `flight_company`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `flight_details`
--
ALTER TABLE `flight_details`
  ADD PRIMARY KEY (`flight_id`,`name`);

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_booking`
--
ALTER TABLE `hotel_booking`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `hotel_booking`
--
ALTER TABLE `hotel_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

