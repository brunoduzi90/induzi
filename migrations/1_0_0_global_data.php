<?php
/**
 * Migracao 1.0.0 - Tabela global_data
 */
return [
    'version' => '1.0.0',
    'desc' => 'Cria tabela global_data para configuracoes globais do sistema',
    'run' => function(PDO $pdo): string {
        $log = [];

        // Verificar se tabela ja existe
        try {
            $pdo->query("SELECT 1 FROM global_data LIMIT 1");
            $log[] = 'Tabela global_data ja existia.';
        } catch (PDOException $e) {
            $pdo->exec("CREATE TABLE global_data (
                data_key VARCHAR(100) PRIMARY KEY,
                data_value LONGTEXT,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
            $log[] = 'Tabela global_data criada.';
        }

        return implode(' ', $log);
    }
];
