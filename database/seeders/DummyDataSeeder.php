<?php
namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Create Medicine Types
        // $medicineTypes = [
        //     ['name' => 'Tablet', 'description' => 'Solid dose form of medication'],
        //     ['name' => 'Capsule', 'description' => 'Medication enclosed in a gelatin shell'],
        //     ['name' => 'Syrup', 'description' => 'Liquid medication with sugar base'],
        //     ['name' => 'Injection', 'description' => 'Medication administered via needle'],
        //     ['name' => 'Cream', 'description' => 'Topical medication with oil and water base'],
        //     ['name' => 'Ointment', 'description' => 'Topical medication with oil base'],
        //     ['name' => 'Drops', 'description' => 'Liquid medication administered in drops'],
        //     ['name' => 'Inhaler', 'description' => 'Medication administered via inhalation'],
        // ];

        // foreach ($medicineTypes as $type) {
        //     MedicineType::create($type);
        // }

        // // Create Medicine Leafs
        // $medicineLeafs = [
        //     ['type' => 'blister', 'qty_box' => 10],
        //     ['type' => 'strip', 'qty_box' => 15],
        //     ['type' => 'bottle', 'qty_box' => 1],
        //     ['type' => 'vial', 'qty_box' => 5],
        //     ['type' => 'ampule', 'qty_box' => 10],
        //     ['type' => 'tube', 'qty_box' => 1],
        //     ['type' => 'sachet', 'qty_box' => 30],
        // ];

        // foreach ($medicineLeafs as $leaf) {
        //     MedicineLeaf::create($leaf);
        // }

        // // Create Medicine Categories
        // $medicineCategories = [
        //     ['name' => 'Analgesics', 'description' => 'Pain relieving medications', 'is_active' => true],
        //     ['name' => 'Antibiotics', 'description' => 'Medications that kill bacteria', 'is_active' => true],
        //     ['name' => 'Antidepressants', 'description' => 'Medications for depression and mood disorders', 'is_active' => true],
        //     ['name' => 'Antihypertensives', 'description' => 'Medications for high blood pressure', 'is_active' => true],
        //     ['name' => 'Antihistamines', 'description' => 'Medications for allergies', 'is_active' => true],
        //     ['name' => 'Antivirals', 'description' => 'Medications that inhibit viruses', 'is_active' => true],
        //     ['name' => 'Corticosteroids', 'description' => 'Anti-inflammatory medications', 'is_active' => true],
        //     ['name' => 'Diuretics', 'description' => 'Medications that increase urine production', 'is_active' => true],
        //     ['name' => 'Antacids', 'description' => 'Medications for acid reflux and heartburn', 'is_active' => true],
        //     ['name' => 'Vitamins', 'description' => 'Dietary supplements', 'is_active' => true],
        //     ['name' => 'Antidiabetics', 'description' => 'Medications for diabetes management', 'is_active' => true],
        //     ['name' => 'Antipsychotics', 'description' => 'Medications for serious mental disorders', 'is_active' => true],
        // ];

        // foreach ($medicineCategories as $category) {
        //     MedicineCategory::create($category);
        // }

        // Create a test Unit, Supplier, and Vendor if they don't exist
        // Unit::create(['name' => 'Tablet', 'description' => 'Tablet']);
        // Unit::create(['name' => 'Bottle', 'description' => 'Bottle']);
        // Unit::create(['name' => 'Tube', 'description' => 'Tube']);
        // Unit::create(['name' => 'Vial', 'description' => 'Vial']);

        // Supplier::create([
        //     'name'                 => 'PharmaMed Distributors',
        //     'email'                => 'contact@pharmamed.com',
        //     'phone'                => '555-123-4567',
        //     'address'              => '123 Pharma Street',
        //     'city'                 => 'New York',
        //     'state'                => 'NY',
        //     'zip'                  => '10001',
        //     'opening_balance'      => 1000,
        //     'opening_balance_type' => 'credit',
        // ]);
        // Supplier::create([
        //     'name'                 => 'Global Health Supplies',
        //     'email'                => 'info@globalhealthsupplies.com',
        //     'phone'                => '555-987-6543',
        //     'address'              => '456 Health Avenue',
        //     'city'                 => 'New York',
        //     'state'                => 'NY',
        //     'zip'                  => '10001',
        //     'opening_balance'      => 1000,
        //     'opening_balance_type' => 'credit',
        // ]);

        // Vendor::create([
        //     'name'                 => 'Johnson Pharma',
        //     'email'                => 'sales@johnsonpharma.com',
        //     'phone'                => '555-333-9876',
        //     'address'              => '789 Medical Boulevard',
        //     'city'                 => 'New York',
        //     'state'                => 'NY',
        //     'zip'                  => '10001',
        //     'opening_balance'      => 1000,
        //     'opening_balance_type' => 'credit',
        // ]);
        // Vendor::create([
        //     'name'                 => 'MediCorp Industries',
        //     'email'                => 'orders@medicorp.com',
        //     'phone'                => '555-444-5555',
        //     'address'              => '321 Medicorp Plaza',
        //     'city'                 => 'New York',
        //     'state'                => 'NY',
        //     'zip'                  => '10001',
        //     'opening_balance'      => 1000,
        //     'opening_balance_type' => 'credit',
        // ]);

        // Create Medicines
        $medicines = [
            [
                'name'                  => 'Paracetamol 500mg',
                'generic_name'          => 'Paracetamol',
                'barcode'               => '8901234567890',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 5.99,
                'purchase_price'        => 3.50,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'A1',
                'dosage'                => '500mg',
                'quantity'              => 1000,
                'batch_number'          => 'PARA2023001',
                'manufacturing_date'    => '2023-01-15',
                'expiration_date'       => '2025-01-15',
                'reorder_level'         => 200,
                'alert_quantity'        => 100,
                'prescription_required' => false,
                'side_effects'          => 'Nausea, stomach pain, loss of appetite',
                'contraindications'     => 'Liver disease, alcoholism',
                'image'                 => null,
                'description'           => 'Pain reliever and fever reducer',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Amoxicillin 250mg',
                'generic_name'          => 'Amoxicillin',
                'barcode'               => '8901234567891',
                'medicine_type_id'      => 2, // Capsule
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 8.99,
                'purchase_price'        => 5.20,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'B2',
                'dosage'                => '250mg',
                'quantity'              => 500,
                'batch_number'          => 'AMOX2023001',
                'manufacturing_date'    => '2023-02-10',
                'expiration_date'       => '2024-02-10',
                'reorder_level'         => 150,
                'alert_quantity'        => 75,
                'prescription_required' => true,
                'side_effects'          => 'Diarrhea, nausea, vomiting, rash',
                'contraindications'     => 'Penicillin allergy',
                'image'                 => null,
                'description'           => 'Antibiotic for bacterial infections',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Lisinopril 10mg',
                'generic_name'          => 'Lisinopril',
                'barcode'               => '8901234567892',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 2, // Strip
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 12.99,
                'purchase_price'        => 7.25,
                'vat_percentage'        => 5,
                'discount_percentage'   => 2,
                'shelf'                 => 'C3',
                'dosage'                => '10mg',
                'quantity'              => 300,
                'batch_number'          => 'LISI2023001',
                'manufacturing_date'    => '2023-03-05',
                'expiration_date'       => '2025-03-05',
                'reorder_level'         => 100,
                'alert_quantity'        => 50,
                'prescription_required' => true,
                'side_effects'          => 'Dizziness, headache, dry cough',
                'contraindications'     => 'Pregnancy, angioedema history',
                'image'                 => null,
                'description'           => 'ACE inhibitor for hypertension',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Cetirizine 10mg',
                'generic_name'          => 'Cetirizine',
                'barcode'               => '8901234567893',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 7.50,
                'purchase_price'        => 4.00,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'A2',
                'dosage'                => '10mg',
                'quantity'              => 750,
                'batch_number'          => 'CETI2023001',
                'manufacturing_date'    => '2023-01-20',
                'expiration_date'       => '2025-01-20',
                'reorder_level'         => 150,
                'alert_quantity'        => 75,
                'prescription_required' => false,
                'side_effects'          => 'Drowsiness, dry mouth, fatigue',
                'contraindications'     => 'Kidney disease, pregnancy',
                'image'                 => null,
                'description'           => 'Antihistamine for allergies',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Ibuprofen 400mg',
                'generic_name'          => 'Ibuprofen',
                'barcode'               => '8901234567894',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 6.99,
                'purchase_price'        => 3.75,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'A3',
                'dosage'                => '400mg',
                'quantity'              => 850,
                'batch_number'          => 'IBUP2023001',
                'manufacturing_date'    => '2023-02-15',
                'expiration_date'       => '2026-02-15',
                'reorder_level'         => 200,
                'alert_quantity'        => 100,
                'prescription_required' => false,
                'side_effects'          => 'Stomach pain, heartburn, dizziness',
                'contraindications'     => 'Stomach ulcers, heart disease',
                'image'                 => null,
                'description'           => 'NSAID for pain and inflammation',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Omeprazole 20mg',
                'generic_name'          => 'Omeprazole',
                'barcode'               => '8901234567895',
                'medicine_type_id'      => 2, // Capsule
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 9.99,
                'purchase_price'        => 5.50,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'D1',
                'dosage'                => '20mg',
                'quantity'              => 400,
                'batch_number'          => 'OMEP2023001',
                'manufacturing_date'    => '2023-03-10',
                'expiration_date'       => '2025-03-10',
                'reorder_level'         => 100,
                'alert_quantity'        => 50,
                'prescription_required' => false,
                'side_effects'          => 'Headache, nausea, diarrhea',
                'contraindications'     => 'Liver disease',
                'image'                 => null,
                'description'           => 'Proton pump inhibitor for acid reflux',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Cough Syrup',
                'generic_name'          => 'Dextromethorphan',
                'barcode'               => '8901234567896',
                'medicine_type_id'      => 3, // Syrup
                'medicine_leaf_id'      => 3, // Bottle
                'unit_id'               => 2, // Bottle
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 12.50,
                'purchase_price'        => 7.00,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'E1',
                'dosage'                => '15mg/5ml',
                'quantity'              => 200,
                'batch_number'          => 'CSYR2023001',
                'manufacturing_date'    => '2023-04-05',
                'expiration_date'       => '2024-04-05',
                'reorder_level'         => 50,
                'alert_quantity'        => 25,
                'prescription_required' => false,
                'side_effects'          => 'Drowsiness, dizziness',
                'contraindications'     => 'MAO inhibitor use',
                'image'                 => null,
                'description'           => 'Cough suppressant',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Metformin 500mg',
                'generic_name'          => 'Metformin',
                'barcode'               => '8901234567897',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 2, // Strip
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 10.99,
                'purchase_price'        => 6.25,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'F1',
                'dosage'                => '500mg',
                'quantity'              => 600,
                'batch_number'          => 'METF2023001',
                'manufacturing_date'    => '2023-01-25',
                'expiration_date'       => '2025-01-25',
                'reorder_level'         => 150,
                'alert_quantity'        => 75,
                'prescription_required' => true,
                'side_effects'          => 'Nausea, diarrhea, stomach pain',
                'contraindications'     => 'Kidney disease, liver disease',
                'image'                 => null,
                'description'           => 'Antidiabetic medication',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Loratadine 10mg',
                'generic_name'          => 'Loratadine',
                'barcode'               => '8901234567898',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 8.50,
                'purchase_price'        => 4.75,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'A4',
                'dosage'                => '10mg',
                'quantity'              => 450,
                'batch_number'          => 'LORA2023001',
                'manufacturing_date'    => '2023-02-20',
                'expiration_date'       => '2025-02-20',
                'reorder_level'         => 100,
                'alert_quantity'        => 50,
                'prescription_required' => false,
                'side_effects'          => 'Headache, dry mouth',
                'contraindications'     => 'Liver disease',
                'image'                 => null,
                'description'           => 'Non-drowsy antihistamine',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Amlodipine 5mg',
                'generic_name'          => 'Amlodipine',
                'barcode'               => '8901234567899',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 2, // Strip
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 14.99,
                'purchase_price'        => 8.50,
                'vat_percentage'        => 5,
                'discount_percentage'   => 2,
                'shelf'                 => 'C1',
                'dosage'                => '5mg',
                'quantity'              => 350,
                'batch_number'          => 'AMLO2023001',
                'manufacturing_date'    => '2023-03-15',
                'expiration_date'       => '2025-03-15',
                'reorder_level'         => 100,
                'alert_quantity'        => 50,
                'prescription_required' => true,
                'side_effects'          => 'Swelling, flushing, headache',
                'contraindications'     => 'Severe hypotension',
                'image'                 => null,
                'description'           => 'Calcium channel blocker for hypertension',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Vitamin C 500mg',
                'generic_name'          => 'Ascorbic Acid',
                'barcode'               => '8901234567900',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 7.99,
                'purchase_price'        => 4.25,
                'vat_percentage'        => 5,
                'discount_percentage'   => 5,
                'shelf'                 => 'G1',
                'dosage'                => '500mg',
                'quantity'              => 1200,
                'batch_number'          => 'VITC2023001',
                'manufacturing_date'    => '2023-01-10',
                'expiration_date'       => '2025-01-10',
                'reorder_level'         => 250,
                'alert_quantity'        => 100,
                'prescription_required' => false,
                'side_effects'          => 'Stomach upset at high doses',
                'contraindications'     => 'Kidney stones history',
                'image'                 => null,
                'description'           => 'Vitamin supplement for immune support',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Azithromycin 500mg',
                'generic_name'          => 'Azithromycin',
                'barcode'               => '8901234567901',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 18.99,
                'purchase_price'        => 10.50,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'B1',
                'dosage'                => '500mg',
                'quantity'              => 300,
                'batch_number'          => 'AZIT2023001',
                'manufacturing_date'    => '2023-02-25',
                'expiration_date'       => '2024-08-25',
                'reorder_level'         => 100,
                'alert_quantity'        => 50,
                'prescription_required' => true,
                'side_effects'          => 'Diarrhea, nausea, abdominal pain',
                'contraindications'     => 'Liver disease, heart rhythm disorders',
                'image'                 => null,
                'description'           => 'Antibiotic for respiratory infections',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Atorvastatin 10mg',
                'generic_name'          => 'Atorvastatin',
                'barcode'               => '8901234567902',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 2, // Strip
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 16.50,
                'purchase_price'        => 9.75,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'C2',
                'dosage'                => '10mg',
                'quantity'              => 400,
                'batch_number'          => 'ATOR2023001',
                'manufacturing_date'    => '2023-03-20',
                'expiration_date'       => '2025-03-20',
                'reorder_level'         => 100,
                'alert_quantity'        => 50,
                'prescription_required' => true,
                'side_effects'          => 'Muscle pain, liver problems, headache',
                'contraindications'     => 'Liver disease, pregnancy',
                'image'                 => null,
                'description'           => 'Statin for cholesterol reduction',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Hydrocortisone Cream 1%',
                'generic_name'          => 'Hydrocortisone',
                'barcode'               => '8901234567903',
                'medicine_type_id'      => 5, // Cream
                'medicine_leaf_id'      => 6, // Tube
                'unit_id'               => 3, // Tube
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 11.99,
                'purchase_price'        => 6.50,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'H1',
                'dosage'                => '1%',
                'quantity'              => 250,
                'batch_number'          => 'HYDR2023001',
                'manufacturing_date'    => '2023-01-30',
                'expiration_date'       => '2024-01-30',
                'reorder_level'         => 50,
                'alert_quantity'        => 25,
                'prescription_required' => false,
                'side_effects'          => 'Skin irritation, thinning of skin',
                'contraindications'     => 'Fungal infections, open wounds',
                'image'                 => null,
                'description'           => 'Corticosteroid for skin inflammation',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Salbutamol Inhaler',
                'generic_name'          => 'Salbutamol',
                'barcode'               => '8901234567904',
                'medicine_type_id'      => 8, // Inhaler
                'medicine_leaf_id'      => 3, // Bottle
                'unit_id'               => 2, // Bottle
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 22.99,
                'purchase_price'        => 13.25,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'I1',
                'dosage'                => '100mcg/dose',
                'quantity'              => 150,
                'batch_number'          => 'SALB2023001',
                'manufacturing_date'    => '2023-02-05',
                'expiration_date'       => '2025-02-05',
                'reorder_level'         => 30,
                'alert_quantity'        => 15,
                'prescription_required' => true,
                'side_effects'          => 'Tremor, tachycardia, headache',
                'contraindications'     => 'Severe heart disease',
                'image'                 => null,
                'description'           => 'Bronchodilator for asthma relief',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Sertraline 50mg',
                'generic_name'          => 'Sertraline',
                'barcode'               => '8901234567905',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 19.99,
                'purchase_price'        => 11.50,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'J1',
                'dosage'                => '50mg',
                'quantity'              => 200,
                'batch_number'          => 'SERT2023001',
                'manufacturing_date'    => '2023-03-25',
                'expiration_date'       => '2025-03-25',
                'reorder_level'         => 50,
                'alert_quantity'        => 25,
                'prescription_required' => true,
                'side_effects'          => 'Nausea, insomnia, dizziness, dry mouth',
                'contraindications'     => 'MAO inhibitor use, pregnancy',
                'image'                 => null,
                'description'           => 'SSRI antidepressant',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Furosemide 40mg',
                'generic_name'          => 'Furosemide',
                'barcode'               => '8901234567906',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 2, // Strip
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 13.50,
                'purchase_price'        => 7.75,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'K1',
                'dosage'                => '40mg',
                'quantity'              => 250,
                'batch_number'          => 'FURO2023001',
                'manufacturing_date'    => '2023-01-05',
                'expiration_date'       => '2025-01-05',
                'reorder_level'         => 75,
                'alert_quantity'        => 40,
                'prescription_required' => true,
                'side_effects'          => 'Frequent urination, dizziness, electrolyte imbalance',
                'contraindications'     => 'Severe kidney disease, allergy to sulfa drugs',
                'image'                 => null,
                'description'           => 'Loop diuretic for fluid retention',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Insulin Vial',
                'generic_name'          => 'Insulin',
                'barcode'               => '8901234567907',
                'medicine_type_id'      => 4, // Injection
                'medicine_leaf_id'      => 4, // Vial
                'unit_id'               => 4, // Vial
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 45.99,
                'purchase_price'        => 28.75,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'L1',
                'dosage'                => '100 IU/ml',
                'quantity'              => 100,
                'batch_number'          => 'INSU2023001',
                'manufacturing_date'    => '2023-02-02',
                'expiration_date'       => '2024-02-02',
                'reorder_level'         => 30,
                'alert_quantity'        => 15,
                'prescription_required' => true,
                'side_effects'          => 'Hypoglycemia, injection site reactions',
                'contraindications'     => 'Hypoglycemia',
                'image'                 => null,
                'description'           => 'Hormone for blood sugar regulation',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Ranitidine 150mg',
                'generic_name'          => 'Ranitidine',
                'barcode'               => '8901234567908',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 1, // Blister
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 9.25,
                'purchase_price'        => 5.00,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'D2',
                'dosage'                => '150mg',
                'quantity'              => 350,
                'batch_number'          => 'RANI2023001',
                'manufacturing_date'    => '2023-01-18',
                'expiration_date'       => '2024-07-18',
                'reorder_level'         => 100,
                'alert_quantity'        => 50,
                'prescription_required' => false,
                'side_effects'          => 'Headache, constipation, diarrhea',
                'contraindications'     => 'Kidney disease',
                'image'                 => null,
                'description'           => 'H2 blocker for acid reduction',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Ciprofloxacin 500mg',
                'generic_name'          => 'Ciprofloxacin',
                'barcode'               => '8901234567909',
                'medicine_type_id'      => 1, // Tablet
                'medicine_leaf_id'      => 2, // Strip
                'unit_id'               => 1, // Tablet
                'supplier_id'           => 1,
                'vendor_id'             => 1,
                'sale_price'            => 16.99,
                'purchase_price'        => 9.25,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'B3',
                'dosage'                => '500mg',
                'quantity'              => 200,
                'batch_number'          => 'CIPR2023001',
                'manufacturing_date'    => '2023-03-01',
                'expiration_date'       => '2025-03-01',
                'reorder_level'         => 75,
                'alert_quantity'        => 40,
                'prescription_required' => true,
                'side_effects'          => 'Nausea, diarrhea, tendon damage',
                'contraindications'     => 'Pregnancy, children, tendon disorders',
                'image'                 => null,
                'description'           => 'Fluoroquinolone antibiotic',
                'is_active'             => true,
            ],
            [
                'name'                  => 'Eye Drops',
                'generic_name'          => 'Tetrahydrozoline',
                'barcode'               => '8901234567910',
                'medicine_type_id'      => 7, // Drops
                'medicine_leaf_id'      => 3, // Bottle
                'unit_id'               => 2, // Bottle
                'supplier_id'           => 2,
                'vendor_id'             => 2,
                'sale_price'            => 8.99,
                'purchase_price'        => 4.50,
                'vat_percentage'        => 5,
                'discount_percentage'   => 0,
                'shelf'                 => 'M1',
                'dosage'                => '0.05%',
                'quantity'              => 180,
                'batch_number'          => 'EYED2023001',
                'manufacturing_date'    => '2023-02-15',
                'expiration_date'       => '2024-02-15',
                'reorder_level'         => 50,
                'alert_quantity'        => 25,
                'prescription_required' => false,
                'side_effects'          => 'Eye irritation, blurred vision',
                'contraindications'     => 'Glaucoma, contact lens wearers',
                'image'                 => null,
                'description'           => 'Eye redness reliever',
                'is_active'             => true,
            ],
        ];

        foreach ($medicines as $medicine) {
            $med = Medicine::create($medicine);

            // Assign categories based on medicine type
            switch ($medicine['name']) {
                case 'Paracetamol 500mg':
                case 'Ibuprofen 400mg':
                    $med->medicine_categories()->attach([4]); // Analgesics
                    break;
                case 'Amoxicillin 250mg':
                case 'Azithromycin 500mg':
                case 'Ciprofloxacin 500mg':
                    $med->medicine_categories()->attach([3]); // Antibiotics
                    break;
                case 'Sertraline 50mg':
                    $med->medicine_categories()->attach([6]); // Antidepressants
                    break;
                case 'Lisinopril 10mg':
                case 'Amlodipine 5mg':
                    $med->medicine_categories()->attach([7]); // Antihypertensives
                    break;
                case 'Cetirizine 10mg':
                case 'Loratadine 10mg':
                    $med->medicine_categories()->attach([8]); // Antihistamines
                    break;
                case 'Hydrocortisone Cream 1%':
                    $med->medicine_categories()->attach([10]); // Corticosteroids
                    break;
                case 'Furosemide 40mg':
                    $med->medicine_categories()->attach([11]); // Diuretics
                    break;
                case 'Omeprazole 20mg':
                case 'Ranitidine 150mg':
                    $med->medicine_categories()->attach([12]); // Antacids
                    break;
                case 'Vitamin C 500mg':
                    $med->medicine_categories()->attach([13]); // Vitamins
                    break;
                case 'Metformin 500mg':
                case 'Insulin Vial':
                    $med->medicine_categories()->attach([14]); // Antidiabetics
                    break;
                case 'Cough Syrup':
                    $med->medicine_categories()->attach([4, 9]); // Analgesics, Antivirals
                    break;
                case 'Atorvastatin 10mg':
                    $med->medicine_categories()->attach([7]); // Using Antihypertensives category
                    break;
                case 'Salbutamol Inhaler':
                                                              // Create new category for respiratory if needed
                    $med->medicine_categories()->attach([9]); // Using Antivirals category
                    break;
                case 'Eye Drops':
                                                              // Create new category for eye care if needed
                    $med->medicine_categories()->attach([8]); // Using Antihistamines category
                    break;
            }
        }
    }
}
