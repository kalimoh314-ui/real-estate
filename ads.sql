CREATE TABLE ads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ad_position VARCHAR(50), -- مكان الإعلان (مثل: 'in_between' أو 'footer')
    ad_type VARCHAR(20),     -- نوع الإعلان: 'image' (بانر مخصص) أو 'code' (جوجل أدسنس)
    image_url VARCHAR(255),  -- رابط صورة البانر في حال كان إعلان مباشر
    target_link VARCHAR(255),-- الرابط الذي ينتقل إليه الزائر عند الضغط
    embed_code TEXT,         -- كود أدسنس النصي في حال كان إعلان تلقائي
    is_active INT DEFAULT 1  -- حالة الإعلان (1 نشط، 0 متوقف)
);
ALTER TABLE ads ADD COLUMN views_count INT DEFAULT 0;
ALTER TABLE ads ADD COLUMN clicks_count INT DEFAULT 0;
