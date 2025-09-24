<?php if (empty($files)): ?>
    <div class="alert alert-warning text-center mt-4">
        Tidak ada file PDF yang ditemukan.
    </div>
<?php else: ?>
    <div class="card shadow-lg border-0 rounded-3 mt-4">
        <div class="card-header bg-primary text-white text-center fw-bold">
            Daftar Dokumen PDF
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Judul</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        foreach ($files as $file): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($file['judul']) ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($file['lokasi']) ?>" target="_blank" 
                                       class="btn btn-info btn-sm">
                                        <i class="bi bi-file-earmark-pdf"></i> Lihat
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($file['tanggal']) ?></td>
                                <td>
                                    <a href="delete_pdf.php?id=<?= urlencode($file['id']) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus file ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
