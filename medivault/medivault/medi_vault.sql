-- Create Users table
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    PasswordHash CHAR(64) NOT NULL, -- Storing hashed passwords (SHA-256)
    Email VARCHAR(100) NOT NULL,
    Age TINYINT UNSIGNED,
    Gender ENUM('Male', 'Female', 'Other'),
    UNIQUE KEY (Username), -- Ensure unique usernames
    UNIQUE KEY (Email) -- Ensure unique emails
);

-- Create HealthRecords table
CREATE TABLE HealthRecords (
    RecordID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    Date DATE,
    Weight DECIMAL(5,2), -- Using DECIMAL for precise floating-point numbers
    Height DECIMAL(5,2),
    BloodPressure VARCHAR(20),
    CholesterolLevel SMALLINT UNSIGNED,
    HeartRate SMALLINT UNSIGNED,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    INDEX(UserID) -- Indexing UserID for faster lookups
);

-- Create Symptoms table
CREATE TABLE Symptoms (
    SymptomID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL,
    Description TEXT,
    UNIQUE KEY (Name) -- Ensure unique symptom names
);

-- Create Diagnoses table
CREATE TABLE Diagnoses (
    DiagnosisID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    SymptomID INT,
    Date DATE,
    DiagnosisDescription TEXT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (SymptomID) REFERENCES Symptoms(SymptomID),
    INDEX(UserID), -- Indexing UserID for faster lookups
    INDEX(SymptomID) -- Indexing SymptomID for faster lookups
);

-- Create Medications table
CREATE TABLE Medications (
    MedicationID INT AUTO_INCREMENT PRIMARY KEY,
    DiagnosisID INT,
    Name VARCHAR(50) NOT NULL,
    Dosage VARCHAR(50),
    Frequency VARCHAR(50),
    StartDate DATE,
    EndDate DATE,
    FOREIGN KEY (DiagnosisID) REFERENCES Diagnoses(DiagnosisID),
    INDEX(DiagnosisID) -- Indexing DiagnosisID for faster lookups
);
ALTER TABLE HealthRecords
ADD COLUMN BMI DECIMAL(5, 2); -- Assuming BMI is stored as a decimal with 5 digits in total and 2 decimal places

--trigger
DELIMITER //

CREATE TRIGGER calculate_bmi_trigger BEFORE INSERT ON HealthRecords
FOR EACH ROW
BEGIN
    DECLARE bmi DECIMAL(5, 2);

    SET bmi = NEW.Weight / (POW((NEW.Height / 100), 2));
    SET NEW.BMI = bmi;
END;
//

DELIMITER ;

INSERT INTO Users(UserID , Username,PasswordHash, Email ,Age,Gender ) VALUES
(1,"taksh","$2y$10$zuy03VmlbLm..WRu6DpWoeqpX8sLZIIh6UAQmu.rSV9...","taksh123@gmail.com",18,"Male"),
(2,"tina","$2y$10$LpOXcL3o3OqUcxoFzbNfxe0iicqeaqTaPeb6A4k7qw9...","tina123@gmail.com",20,"Female"),
(3,"siri","$2y$10$0UNCBQpPflu68tq38fW/ReKiskrS3N28uRPncW1UBGN...","siri123@gmail.com",18,"Female");


INSERT INTO Symptoms (SymptomID, Name, Description) VALUES
(1, 'Headache', 'Pain in the head region'),
(2, 'Fever', 'Elevated body temperature'),
(3, 'Cough', 'Expelling air from the lungs with a sudden sharp sound'),
(4, 'Nausea', 'Feeling of wanting to vomit'),
(5, 'Fatigue', 'Extreme tiredness'),
(6, 'Shortness of breath', 'Difficulty in breathing'),
(7, 'Muscle pain', 'Ache or discomfort in muscles'),
(8, 'Sore throat', 'Pain or irritation in the throat'),
(9, 'Runny nose', 'Flow of fluid from the nasal passages'),
(10, 'Sneezing', 'Expelling air forcibly from the nose and mouth'),
(11, 'Watery eyes', 'Excessive tear production'),
(12, 'Chills', 'Sensation of cold with shivering'),
(13, 'Loss of appetite', 'Reduction in desire to eat'),
(14, 'Joint pain', 'Ache or discomfort in the joints'),
(15, 'Vomiting', 'Expelling stomach contents through the mouth'),
(16, 'Diarrhea', 'Passing of loose or watery stools'),
(17, 'Constipation', 'Difficulty in passing stools'),
(18, 'Dizziness', 'Sensation of lightheadedness or unsteadiness'),
(19, 'Abdominal pain', 'Pain or discomfort in the abdomen'),
(20, 'Dehydration', 'Excessive loss of body fluids'),
(21, 'Difficulty sleeping', 'Trouble falling asleep or staying asleep'),
(22, 'Rapid heartbeat', 'Increased heart rate'),
(23, 'High blood pressure', 'Elevated blood pressure readings'),
(24, 'Low blood pressure', 'Decreased blood pressure readings'),
(25, 'Muscle weakness', 'Reduced strength or power in muscles'),
(26, 'Skin rash', 'Abnormal changes in skin texture or appearance'),
(27, 'Frequent urination', 'Passing urine more often than usual'),
(28, 'Difficulty swallowing', 'Trouble moving food or liquid from the mouth to the stomach'),
(29, 'Chest pain', 'Discomfort or pain in the chest region'),
(30, 'Back pain', 'Discomfort or pain in the back region'),
(31, 'Sweating', 'Production of sweat from the skin'),
(32, 'Numbness or tingling', 'Loss of sensation or abnormal sensation in body parts'),
(33, 'Memory problems', 'Difficulty in remembering or recalling information'),
(34, 'Confusion', 'State of disorientation or lack of clarity'),
(35, 'Mood swings', 'Sudden and intense changes in mood or emotions'),
(36, 'Anxiety', 'Feeling of worry or nervousness'),
(37, 'Depression', 'Feelings of sadness or low mood'),
(38, 'Hallucinations', 'Perception of objects or sensations that are not present'),
(39, 'Delusions', 'Beliefs or perceptions that are not based on reality'),
(40, 'Paranoia', 'Extreme distrust or suspicion of others'),
(41, 'Insomnia', 'Difficulty in falling asleep or staying asleep'),
(42, 'Nightmares', 'Disturbing dreams during sleep'),
(43, 'Agitation', 'State of restlessness or irritability'),
(44, 'Tremors', 'Involuntary shaking or trembling of body parts'),
(45, 'Seizures', 'Sudden and uncontrolled electrical disturbances in the brain'),
(46, 'Fainting', 'Temporary loss of consciousness'),
(47, 'Vertigo', 'Sensation of spinning or whirling'),
(48, 'Blurred vision', 'Loss of sharpness or clarity of vision'),
(49, 'Double vision', 'Perception of two images of a single object'),
(50, 'Sensitivity to light', 'Increased sensitivity to light'),
(51, 'Sensitivity to sound', 'Increased sensitivity to sound'),
(52, 'Loss of balance', 'Difficulty in maintaining equilibrium or steadiness'),
(53, 'Weakness in limbs', 'Reduced strength or power in arms or legs'),
(54, 'Difficulty speaking', 'Trouble articulating words or producing speech sounds'),
(55, 'Slurred speech', 'Speech that is unclear or difficult to understand'),
(56, 'Loss of consciousness', 'Complete loss of awareness or responsiveness'),
(57, 'Paralysis', 'Loss of muscle function in part of the body'),
(58, 'Twitching muscles', 'Involuntary contractions or movements of muscles'),
(59, 'Muscle stiffness', 'Difficulty in moving or bending muscles'),
(60, 'Numbness in limbs', 'Loss of sensation or feeling in arms or legs'),
(61, 'Bleeding gums', 'Presence of blood during brushing or flossing of teeth'),
(62, 'Swollen glands', 'Enlargement or puffiness of lymph nodes'),
(63, 'Mouth ulcers', 'Painful sores or lesions in the mouth'),
(64, 'White patches in mouth', 'Areas of white coloration on the inner lining of the mouth'),
(65, 'Difficulty chewing', 'Trouble breaking down food with the teeth'),
(66, 'Jaw pain', 'Discomfort or pain in the jaw region'),
(67, 'Neck pain', 'Discomfort or pain in the neck region'),
(68, 'Shoulder pain', 'Discomfort or pain in the shoulder region'),
(69, 'Arm pain', 'Discomfort or pain in the arm region'),
(70, 'Elbow pain', 'Discomfort or pain in the elbow region'),
(71, 'Wrist pain', 'Discomfort or pain in the wrist region'),
(72, 'Hand pain', 'Discomfort or pain in the hand region'),
(73, 'Finger pain', 'Discomfort or pain in the finger region'),
(74, 'Hip pain', 'Discomfort or pain in the hip region'),
(75, 'Thigh pain', 'Discomfort or pain in the thigh region'),
(76, 'Knee pain', 'Discomfort or pain in the knee region'),
(77, 'Leg pain', 'Discomfort or pain in the leg region'),
(78, 'Ankle pain', 'Discomfort or pain in the ankle region'),
(79, 'Foot pain', 'Discomfort or pain in the foot region'),
(80, 'Toe pain', 'Discomfort or pain in the toe region'),
(81, 'Burning sensation', 'Feeling of heat or warmth in body parts'),
(82, 'Numbness or tingling', 'Loss of sensation or abnormal sensation in body parts');



