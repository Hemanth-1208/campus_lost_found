-- Run this once in phpMyAdmin after selecting the smart_campus_lost_found database.
-- Adds the extra details collected by the updated item claim form.
ALTER TABLE claims
    ADD COLUMN claimant_name VARCHAR(100) NOT NULL DEFAULT '' AFTER user_id,
    ADD COLUMN class_section VARCHAR(60) NOT NULL DEFAULT '' AFTER claimant_name,
    ADD COLUMN handover_location VARCHAR(150) NOT NULL DEFAULT '' AFTER class_section;
