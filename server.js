const express = require("express");
const bodyParser = require("body-parser");
const { Pool } = require("pg");
const cors = require("cors");

const app = express();
const port = process.env.PORT || 3000;

app.use(bodyParser.json());
app.use(cors());

// PostgreSQL connection
const pool = new Pool({
  user: "postgres",
  host: "localhost",
  database: "Aplikasi",
  password: "emilda123",
  port: 5432,
});

// Basic route
app.get("/", (req, res) => {
  res.send("Hello World!");
});

// Route untuk menambahkan operation_report
app.post("/api/operation-reports", async (req, res) => {
  const { tanggal, shift, grup, pengawas, lokasi, status, pic } = req.body;

  const client = await pool.connect();

  try {
    await client.query("BEGIN");

    // Validasi input
    if (
      !tanggal ||
      !shift ||
      !grup ||
      !pengawas ||
      !lokasi ||
      !status ||
      !pic
    ) {
      throw new Error("Data operasi tidak lengkap");
    }

    // Validasi status
    if (status !== "PRODUCTION" && status !== "HOUR_METER") {
      throw new Error('Status harus berupa "PRODUCTION" atau "HOUR_METER"');
    }

    const operationResult = await client.query(
      "INSERT INTO operation_report(tanggal, shift, grup, pengawas, lokasi, status, pic) VALUES($1, $2, $3, $4, $5, $6, $7) RETURNING id",
      [tanggal, shift, grup, pengawas, lokasi, status, pic]
    );

    const operationReportId = operationResult.rows[0].id;

    await client.query("COMMIT");
    res.status(201).json({
      message: "Operation report created successfully",
      operationReportId,
      status,
    });
  } catch (error) {
    await client.query("ROLLBACK");
    console.error("Error inserting operation data", error);
    res.status(400).json({
      error: error.message || "Terjadi kesalahan saat menyimpan data operasi",
    });
  } finally {
    client.release();
  }
});

// Route untuk menampilkan semua data dari operation_report
app.get("/api/operation-reports", async (req, res) => {
  try {
    const { startDate, endDate } = req.query;
    let query = "SELECT * FROM operation_report";
    const params = [];

    if (startDate || endDate) {
      query += " WHERE";
      if (startDate && endDate) {
        query += " tanggal BETWEEN $1 AND $2";
        params.push(startDate, endDate);
      } else if (startDate) {
        query += " tanggal >= $1";
        params.push(startDate);
      } else if (endDate) {
        query += " tanggal <= $1";
        params.push(endDate);
      }
    }

    query += " ORDER BY tanggal DESC";

    const result = await pool.query(query, params);
    res.json(result.rows);
  } catch (error) {
    console.error("Error fetching operation reports", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat mengambil data operation report",
    });
  }
});

// Route untuk menambahkan production_report
app.post("/api/production-reports", async (req, res) => {
  const {
    alat,
    timbunan,
    material,
    jarak,
    tipe,
    ritase,
    operation_report_id,
  } = req.body;

  const client = await pool.connect();

  try {
    await client.query("BEGIN");

    // Validasi input
    const requiredFields = [
      "alat",
      "timbunan",
      "material",
      "jarak",
      "tipe",
      "ritase",
      "operation_report_id",
    ];
    const missingFields = requiredFields.filter((field) => !req.body[field]);

    if (missingFields.length > 0) {
      throw new Error(
        `Data produksi tidak lengkap. Field yang hilang: ${missingFields.join(
          ", "
        )}`
      );
    }

    // Validasi tipe data
    if (isNaN(parseFloat(jarak))) {
      throw new Error("Jarak harus berupa angka");
    }
    if (isNaN(parseInt(ritase))) {
      throw new Error("Ritase harus berupa angka bulat");
    }

    // Periksa apakah operation_report_id valid
    const operationCheck = await client.query(
      "SELECT id, status FROM operation_report WHERE id = $1",
      [operation_report_id]
    );
    if (operationCheck.rows.length === 0) {
      throw new Error("Operation report dengan ID tersebut tidak ditemukan");
    }
    if (operationCheck.rows[0].status !== "PRODUCTION") {
      throw new Error("Operation report ini bukan untuk production");
    }

    const result = await client.query(
      "INSERT INTO production_report(alat, timbunan, material, jarak, tipe, ritase, operation_report_id) VALUES($1, $2, $3, $4, $5, $6, $7) RETURNING id",
      [
        alat,
        timbunan,
        material,
        parseFloat(jarak),
        tipe,
        parseInt(ritase),
        operation_report_id,
      ]
    );

    await client.query("COMMIT");

    res.status(201).json({
      message: "Production report berhasil dibuat",
      id: result.rows[0].id,
    });
  } catch (error) {
    await client.query("ROLLBACK");
    console.error("Error saat menyisipkan data produksi:", error);
    res.status(400).json({
      error: error.message || "Terjadi kesalahan saat menyimpan data produksi",
    });
  } finally {
    client.release();
  }
});

// Route untuk menampilkan data production_report dengan relasi ke operation_report
app.get("/api/production-reports", async (req, res) => {
  try {
    const { startDate, endDate, grup, lokasi } = req.query;
    let query = `
      SELECT pr.*, op_report.tanggal, op_report.grup, op_report.lokasi
      FROM production_report pr
      JOIN operation_report op_report ON pr.operation_report_id = op_report.id
    `;
    const params = [];
    let whereClause = [];

    if (startDate && endDate) {
      whereClause.push(
        `op_report.tanggal BETWEEN $${params.length + 1} AND $${
          params.length + 2
        }`
      );
      params.push(startDate, endDate);
    } else if (startDate) {
      whereClause.push(`op_report.tanggal >= $${params.length + 1}`);
      params.push(startDate);
    } else if (endDate) {
      whereClause.push(`op_report.tanggal <= $${params.length + 1}`);
      params.push(endDate);
    }

    if (grup) {
      whereClause.push(`op_report.grup = $${params.length + 1}`);
      params.push(grup);
    }

    if (lokasi) {
      whereClause.push(`op_report.lokasi = $${params.length + 1}`);
      params.push(lokasi);
    }

    if (whereClause.length > 0) {
      query += " WHERE " + whereClause.join(" AND ");
    }

    query += " ORDER BY op_report.tanggal DESC, pr.id";

    console.log("Executing SQL query:", query);
    console.log("With parameters:", params);

    const result = await pool.query(query, params);
    console.log("Query result:", JSON.stringify(result.rows, null, 2));
    console.log(
      "Lokasi values:",
      result.rows.map((row) => row.lokasi)
    );
    res.json(result.rows);
  } catch (error) {
    console.error("Error fetching production reports", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat mengambil data production report",
    });
  }
});

// Route untuk menghapus production_report
app.delete("/api/production-reports/:id", async (req, res) => {
  const { id } = req.params;

  try {
    const result = await pool.query(
      "DELETE FROM production_report WHERE id = $1 RETURNING *",
      [id]
    );

    if (result.rows.length === 0) {
      return res
        .status(404)
        .json({ error: "Laporan produksi tidak ditemukan" });
    }

    res.json({
      message: "Laporan produksi berhasil dihapus",
      deletedReport: result.rows[0],
    });
  } catch (error) {
    console.error("Error deleting production report", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat menghapus laporan produksi",
    });
  }
});

// Route untuk mengambil production_report berdasarkan ID
app.get("/api/production-reports/:id", async (req, res) => {
  const { id } = req.params;
  try {
    const result = await pool.query(
      `SELECT pr.*, op_report.tanggal, op_report.grup, op_report.lokasi
       FROM production_report pr
       JOIN operation_report op_report ON pr.operation_report_id = op_report.id
       WHERE pr.id = $1`,
      [id]
    );
    if (result.rows.length === 0) {
      return res
        .status(404)
        .json({ error: "Laporan produksi tidak ditemukan" });
    }
    res.json(result.rows[0]);
  } catch (error) {
    console.error("Error fetching production report", error);
    res
      .status(500)
      .json({
        error: "Terjadi kesalahan saat mengambil data laporan produksi",
      });
  }
});

// Route untuk mengupdate production_report
app.put("/api/production-reports/:id", async (req, res) => {
  const { id } = req.params;
  const {
    alat,
    timbunan,
    material,
    jarak,
    tipe,
    ritase,
    operation_report_id,
  } = req.body;

  try {
    // Validasi input
    if (
      !alat ||
      !timbunan ||
      !material ||
      !jarak ||
      !tipe ||
      !ritase ||
      !operation_report_id
    ) {
      return res.status(400).json({ error: "Semua field harus diisi" });
    }

    // Validasi tipe data
    if (isNaN(parseFloat(jarak))) {
      return res.status(400).json({ error: "Jarak harus berupa angka" });
    }
    if (isNaN(parseInt(ritase))) {
      return res.status(400).json({ error: "Ritase harus berupa angka bulat" });
    }

    const result = await pool.query(
      `UPDATE production_report 
       SET alat = $1, timbunan = $2, material = $3, jarak = $4, tipe = $5, ritase = $6, operation_report_id = $7 
       WHERE id = $8 
       RETURNING *`,
      [
        alat,
        timbunan,
        material,
        parseFloat(jarak),
        tipe,
        parseInt(ritase),
        operation_report_id,
        id,
      ]
    );

    if (result.rows.length === 0) {
      return res
        .status(404)
        .json({ error: "Laporan produksi tidak ditemukan" });
    }

    res.json(result.rows[0]);
  } catch (error) {
    console.error("Error updating production report", error);
    res
      .status(500)
      .json({ error: "Terjadi kesalahan saat mengupdate laporan produksi" });
  }
});

// Route untuk menambahkan hourmeter_report
app.post("/api/hourmeter-reports", async (req, res) => {
  const {
    operation_report_id,
    equipment,
    hm_awal,
    hm_akhir,
    jam_lain,
    breakdown,
    no_operator,
    hujan,
    ket,
  } = req.body;

  const client = await pool.connect();

  try {
    await client.query("BEGIN");

    // Validasi input
    const requiredFields = [
      "operation_report_id",
      "equipment",
      "hm_awal",
      "hm_akhir",
      "jam_lain",
      "breakdown",
      "no_operator",
      "hujan",
      "ket",
    ];
    const missingFields = requiredFields.filter((field) => !req.body[field]);

    if (missingFields.length > 0) {
      throw new Error(
        `Data hour meter tidak lengkap. Field yang hilang: ${missingFields.join(
          ", "
        )}`
      );
    }

    if (isNaN(parseFloat(hm_awal))) {
      throw new Error("HM Awal harus berupa angka");
    }
    if (isNaN(parseFloat(hm_akhir))) {
      throw new Error("HM Akhir harus berupa angka");
    }
    if (isNaN(parseFloat(jam_lain))) {
      throw new Error("Jam Lain harus berupa angka");
    }
    if (isNaN(parseFloat(breakdown))) {
      throw new Error("Breakdown harus berupa angka");
    }
    if (isNaN(parseFloat(no_operator))) {
      throw new Error("No Operator harus berupa angka");
    }
    if (isNaN(parseFloat(hujan))) {
      throw new Error("Hujan harus berupa angka");
    }

    // Periksa apakah operation_report_id valid
    const operationCheck = await client.query(
      "SELECT id, status FROM operation_report WHERE id = $1",
      [operation_report_id]
    );
    if (operationCheck.rows.length === 0) {
      throw new Error("Operation report dengan ID tersebut tidak ditemukan");
    }
    if (operationCheck.rows[0].status !== "HOUR_METER") {
      throw new Error("Operation report ini bukan untuk hour meter");
    }

    const result = await client.query(
      "INSERT INTO hourmeter_report(operation_report_id, equipment, hm_awal, hm_akhir, jam_lain, breakdown, no_operator, hujan, ket) VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9) RETURNING id",
      [
        operation_report_id,
        equipment,
        hm_awal,
        hm_akhir,
        jam_lain,
        breakdown,
        no_operator,
        hujan,
        ket,
      ]
    );

    await client.query("COMMIT");

    res.status(201).json({
      message: "Hour Meter report berhasil dibuat",
      id: result.rows[0].id,
    });
  } catch (error) {
    await client.query("ROLLBACK");
    console.error("Error saat menyisipkan data hour meter:", error);
    res.status(400).json({
      error:
        error.message || "Terjadi kesalahan saat menyimpan data hour meter",
    });
  } finally {
    client.release();
  }
});

app.get("/api/hourmeter-reports", async (req, res) => {
  try {
    const { startDate, endDate, grup, lokasi, shift } = req.query;
    console.log("Received query params:", {
      startDate,
      endDate,
      grup,
      lokasi,
      shift,
    }); // Log parameter yang diterima

    let query = `
      SELECT hr.*, op_report.tanggal, op_report.grup, op_report.lokasi, op_report.shift
      FROM hourmeter_report hr
      JOIN operation_report op_report ON hr.operation_report_id = op_report.id
    `;
    const params = [];
    let whereClause = [];

    if (startDate && endDate) {
      whereClause.push(
        `op_report.tanggal BETWEEN $${params.length + 1} AND $${
          params.length + 2
        }`
      );
      params.push(startDate, endDate);
    } else if (startDate) {
      whereClause.push(`op_report.tanggal >= $${params.length + 1}`);
      params.push(startDate);
    } else if (endDate) {
      whereClause.push(`op_report.tanggal <= $${params.length + 1}`);
      params.push(endDate);
    }

    if (grup) {
      whereClause.push(`LOWER(op_report.grup) = LOWER($${params.length + 1})`);
      params.push(grup);
    }

    if (lokasi) {
      whereClause.push(
        `LOWER(op_report.lokasi) = LOWER($${params.length + 1})`
      );
      params.push(lokasi);
    }

    if (shift) {
      whereClause.push(`LOWER(op_report.shift) = LOWER($${params.length + 1})`);
      params.push(shift);
    }

    if (whereClause.length > 0) {
      query += " WHERE " + whereClause.join(" AND ");
    }

    query += " ORDER BY op_report.tanggal DESC, hr.id";

    console.log("Executing SQL query:", query);
    console.log("With parameters:", params);

    const result = await pool.query(query, params);
    console.log(`Query returned ${result.rows.length} rows`);
    console.log("First few results:", result.rows.slice(0, 3)); // Log beberapa hasil pertama

    res.json(result.rows);
  } catch (error) {
    console.error("Error fetching hourmeter reports", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat mengambil data hourmeter report",
    });
  }
});

// Route untuk menghapus hourmeter_report
app.delete("/api/hourmeter-reports/:id", async (req, res) => {
  const { id } = req.params;

  try {
    const result = await pool.query(
      "DELETE FROM hourmeter_report WHERE id = $1 RETURNING *",
      [id]
    );

    if (result.rows.length === 0) {
      return res
        .status(404)
        .json({ error: "Laporan hour meter tidak ditemukan" });
    }

    res.json({
      message: "Laporan hour meter berhasil dihapus",
      deletedReport: result.rows[0],
    });
  } catch (error) {
    console.error("Error deleting hour meter report", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat menghapus laporan hour meter",
    });
  }
});

// Route untuk mengambil hourmeter_report berdasarkan ID
app.get("/api/hourmeter-reports/:id", async (req, res) => {
  const { id } = req.params;
  try {
    const result = await pool.query(
      `SELECT hr.*, op_report.tanggal, op_report.grup, op_report.lokasi, op_report.shift
       FROM hourmeter_report hr
       JOIN operation_report op_report ON hr.operation_report_id = op_report.id
       WHERE hr.id = $1`,
      [id]
    );
    if (result.rows.length === 0) {
      return res
        .status(404)
        .json({ error: "Laporan hour meter tidak ditemukan" });
    }
    res.json(result.rows[0]);
  } catch (error) {
    console.error("Error fetching hourmeter report", error);
    res
      .status(500)
      .json({
        error: "Terjadi kesalahan saat mengambil data laporan hour meter",
      });
  }
});

// Route untuk mengupdate hourmeter_report
app.put("/api/hourmeter-reports/:id", async (req, res) => {
  const { id } = req.params;
  const {
    equipment,
    hm_awal,
    hm_akhir,
    jam_lain,
    breakdown,
    no_operator,
    hujan,
    ket,
    operation_report_id,
  } = req.body;

  try {
    // Validasi input
    if (
      !equipment ||
      !hm_awal ||
      !hm_akhir ||
      !jam_lain ||
      !breakdown ||
      !no_operator ||
      !hujan ||
      !ket ||
      !operation_report_id
    ) {
      return res.status(400).json({ error: "Semua field harus diisi" });
    }

    // Validasi tipe data
    if (
      isNaN(parseFloat(hm_awal)) ||
      isNaN(parseFloat(hm_akhir)) ||
      isNaN(parseFloat(jam_lain)) ||
      isNaN(parseFloat(breakdown)) ||
      isNaN(parseInt(no_operator)) ||
      isNaN(parseFloat(hujan))
    ) {
      return res.status(400).json({ error: "Format input tidak valid" });
    }

    const result = await pool.query(
      `UPDATE hourmeter_report 
       SET equipment = $1, hm_awal = $2, hm_akhir = $3, jam_lain = $4, breakdown = $5, 
           no_operator = $6, hujan = $7, ket = $8, operation_report_id = $9 
       WHERE id = $10 
       RETURNING *`,
      [
        equipment,
        parseFloat(hm_awal),
        parseFloat(hm_akhir),
        parseFloat(jam_lain),
        parseFloat(breakdown),
        parseInt(no_operator),
        parseFloat(hujan),
        ket,
        operation_report_id,
        id,
      ]
    );

    if (result.rows.length === 0) {
      return res
        .status(404)
        .json({ error: "Laporan hour meter tidak ditemukan" });
    }

    res.json(result.rows[0]);
  } catch (error) {
    console.error("Error updating hourmeter report", error);
    res
      .status(500)
      .json({ error: "Terjadi kesalahan saat mengupdate laporan hour meter" });
  }
});

// Route untuk menambahkan admin
app.post("/api/admin", async (req, res) => {
  console.log("Received request body:", req.body); // Log the entire request body
  const { nama, username, password } = req.body;

  const client = await pool.connect();

  try {
    await client.query("BEGIN");

    // Validasi input
    if (!nama || !username || !password) {
      throw new Error("Data admin tidak lengkap");
    }

    const result = await client.query(
      "INSERT INTO admin_report(nama, username, password) VALUES($1, $2, $3) RETURNING id",
      [nama, username, password]
    );

    await client.query("COMMIT");

    res.status(201).json({
      message: "Admin berhasil ditambahkan",
      id: result.rows[0].id,
    });
  } catch (error) {
    await client.query("ROLLBACK");
    console.error("Error saat menambahkan admin:", error);
    res.status(400).json({
      error: error.message || "Terjadi kesalahan saat menambahkan admin",
    });
  } finally {
    client.release();
  }
});

app.get("/api/admin", async (req, res) => {
  try {
    const result = await pool.query(
      "SELECT * FROM admin_report ORDER BY id DESC"
    );
    res.json(result.rows);
  } catch (error) {
    console.error("Error fetching admin data", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat mengambil data admin",
    });
  }
});

app.get("/api/admin/:id", async (req, res) => {
  const { id } = req.params;
  try {
    const result = await pool.query(
      "SELECT * FROM admin_report WHERE id = $1",
      [id]
    );
    if (result.rows.length === 0) {
      return res.status(404).json({ error: "Admin not found" });
    }
    res.json(result.rows[0]);
  } catch (error) {
    console.error("Error fetching admin data", error);
    res
      .status(500)
      .json({ error: "Terjadi kesalahan saat mengambil data admin" });
  }
});

app.delete("/api/admin/:id", async (req, res) => {
  const { id } = req.params;

  try {
    const result = await pool.query(
      "DELETE FROM admin_report WHERE id = $1 RETURNING *",
      [id]
    );

    if (result.rows.length === 0) {
      return res.status(404).json({ error: "Admin tidak ditemukan" });
    }

    res.json({
      message: "Admin berhasil dihapus",
      deletedAdmin: result.rows[0],
    });
  } catch (error) {
    console.error("Error deleting admin", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat menghapus admin",
    });
  }
});

app.put("/api/admin/:id", async (req, res) => {
  const { id } = req.params;
  const { nama, username, password } = req.body;
  // const client = await pool.connect();
  try {
    // await client.query("BEGIN");
    // Validasi input
    if (!nama || !username || !password) {
      throw new Error("Data admin tidak lengkap");
    }

    const result = await pool.query(
      `UPDATE admin_report SET nama = $1, username = $2, password = $3 WHERE id = $4 RETURNING *`,
      [nama, username, password, id]
    );

    if (result.rows.length === 0) {
      return res.status(404).json({ error: "Admin tidak ditemukan" });
    }
    // await client.query("COMMIT");

    res.json({
      message: "Admin berhasil diupdate",
      updatedAdmin: result.rows[0],
    });
  } catch (error) {
    // await client.query("ROLLBACK");
    console.error("Error saat mengupdate admin:", error);
    res.status(400).json({
      error: error.message || "Terjadi kesalahan saat mengupdate admin",
    });
  }
  // finally {
  //     client.release();
  // }
});

// Route untuk menambahkan user
app.post("/api/user", async (req, res) => {
  console.log("Received request body:", req.body); // Log the entire request body
  const { nama, username, password } = req.body;

  const client = await pool.connect();

  try {
    await client.query("BEGIN");

    // Validasi input
    if (!nama || !username || !password) {
      throw new Error("Data user tidak lengkap");
    }

    const result = await client.query(
      "INSERT INTO user_report(nama, username, password) VALUES($1, $2, $3) RETURNING id",
      [nama, username, password]
    );

    await client.query("COMMIT");

    res.status(201).json({
      message: "User berhasil ditambahkan",
      id: result.rows[0].id,
    });
  } catch (error) {
    await client.query("ROLLBACK");
    console.error("Error saat menambahkan user:", error);
    res.status(400).json({
      error: error.message || "Terjadi kesalahan saat menambahkan user",
    });
  } finally {
    client.release();
  }
});

app.get("/api/user", async (req, res) => {
  try {
    const result = await pool.query(
      "SELECT * FROM user_report ORDER BY id DESC"
    );
    res.json(result.rows);
  } catch (error) {
    console.error("Error fetching user data", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat mengambil data user",
    });
  }
});

app.get("/api/user/:id", async (req, res) => {
  const { id } = req.params;
  try {
    const result = await pool.query(
      "SELECT * FROM user_report WHERE id = $1",
      [id]
    );
    if (result.rows.length === 0) {
      return res.status(404).json({ error: "User not found" });
    }
    res.json(result.rows[0]);
  } catch (error) {
    console.error("Error fetching user data", error);
    res
      .status(500)
      .json({ error: "Terjadi kesalahan saat mengambil data user" });
  }
});

app.delete("/api/user/:id", async (req, res) => {
  const { id } = req.params;

  try {
    const result = await pool.query(
      "DELETE FROM user_report WHERE id = $1 RETURNING *",
      [id]
    );

    if (result.rows.length === 0) {
      return res.status(404).json({ error: "User tidak ditemukan" });
    }

    res.json({
      message: "User berhasil dihapus",
      deletedAdmin: result.rows[0],
    });
  } catch (error) {
    console.error("Error deleting user", error);
    res.status(500).json({
      error: "Terjadi kesalahan saat menghapus user",
    });
  }
});

app.put("/api/user/:id", async (req, res) => {
  const { id } = req.params;
  const { nama, username, password } = req.body;
  // const client = await pool.connect();
  try {
    // await client.query("BEGIN");
    // Validasi input
    if (!nama || !username || !password) {
      throw new Error("Data user tidak lengkap");
    }

    const result = await pool.query(
      `UPDATE user_report SET nama = $1, username = $2, password = $3 WHERE id = $4 RETURNING *`,
      [nama, username, password, id]
    );

    if (result.rows.length === 0) {
      return res.status(404).json({ error: "User tidak ditemukan" });
    }
    // await client.query("COMMIT");

    res.json({
      message: "User berhasil diupdate",
      updatedUser: result.rows[0],
    });
  } catch (error) {
    // await client.query("ROLLBACK");
    console.error("Error saat mengupdate admin:", error);
    res.status(400).json({
      error: error.message || "Terjadi kesalahan saat mengupdate admin",
    });
  }
  // finally {
  //     client.release();
  // }
});

// Route untuk login
app.post("/api/login", async (req, res) => {
  const { username, password, akses } = req.body;

  try {
    // Validasi input
    if (!username || !password || !akses) {
      return res.status(400).json({ error: "Semua field harus diisi" });
    }

    // Cek di tabel admin
    if (akses === "admin") {
      const adminResult = await pool.query(
        "SELECT * FROM admin_report WHERE username = $1 AND password = $2",
        [username, password]
      );

       if (adminResult.rows.length > 0) {
        const admin = adminResult.rows[0];
        return res.json({ message: "Login berhasil", role: "admin", name: admin.nama });
      }
    }

    // Cek di tabel user
    if (akses === "user") {
      const userResult = await pool.query(
        "SELECT * FROM user_report WHERE username = $1 AND password = $2",
        [username, password]
      );

      if (userResult.rows.length > 0) {
       const user = userResult.rows[0];
        return res.json({ message: "Login berhasil", role: "user", name: user.nama });
      }
    }

    // Jika tidak ditemukan
    res.status(401).json({ error: "Username, password, atau hak akses salah" });
  } catch (error) {
    console.error("Error saat login:", error);
    res.status(500).json({ error: "Terjadi kesalahan saat login" });
  }
});

// app.post("/api/logout", (req, res) => {
//   // Assuming you are using express-session or similar middleware
//   req.session.destroy(err => {
//     if (err) {
//       return res.status(500).json({ error: "Terjadi kesalahan saat logout" });
//     }
//     res.json({ message: "Logout berhasil" });
//   });
// });

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
