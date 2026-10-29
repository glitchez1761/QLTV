<?php
class ReturnService {
    public static function calculatePenalty(
        string $dueDate,
        string $returnedAt,
        string $condition,
        float $replacementValue
    ): array {
        if (!in_array($condition, ['NGUYEN_VEN', 'HU_HONG', 'MAT'], true)) {
            throw new InvalidArgumentException('Tình trạng sách khi trả không hợp lệ.');
        }

        $due = new DateTimeImmutable($dueDate);
        $returned = new DateTimeImmutable($returnedAt);
        $overdueDays = max(0, (int)$due->diff($returned)->format('%r%a'));
        $overdueFine = $overdueDays * OVERDUE_FINE_PER_DAY;
        $compensation = $condition === 'NGUYEN_VEN' ? 0.0 : $replacementValue;
        $processingFee = $condition === 'NGUYEN_VEN' ? 0.0 : BOOK_PROCESSING_FEE;
        $type = $condition === 'MAT' ? 'MAT_TAI_LIEU' : ($condition === 'HU_HONG' ? 'HU_HONG' : 'TRA_QUA_HAN');
        $hasViolation = $overdueDays > 0 || $condition !== 'NGUYEN_VEN';

        return [
            'has_violation' => $hasViolation,
            'violation_type' => $type,
            'overdue_days' => $overdueDays,
            'overdue_fine' => $overdueFine,
            'compensation_fee' => $compensation,
            'processing_fee' => $processingFee,
            'total_amount' => $overdueFine + $compensation + $processingFee,
        ];
    }
}
