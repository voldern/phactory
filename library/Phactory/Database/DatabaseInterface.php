<?php
namespace Phactory\Database;

/**
 * Database interface
 *
 * @author Espen Volden <voldern@hoeggen.net>
 * @package Database
 */
interface DatabaseInterface {
    /**
     * Connect to database
     *
     * @throws SetupException
     * @param array $config Database config
     * @return DatabaseInterface
     */
    public function connect(array $config);

    /**
     * Insert rows
     *
     * @param array $rows Rows
     * @return DatabaseInterface
     * @throws RuntimeException
     */
    public function insertRows(array $rows);

    /**
     * Get rows that has been inserted into the DB during this session
     *
     * @return null|array
     */
    public function getInsertedRows();

    /**
     * Remove rows has been inserted into the DB during this session
     *
     * @return DatabaseInterface
     */
    public function removeInsertedRows();

    /**
     * Clear list of inserted rows during this session
     *
     * @return DatabaseInterface
     */
    public function clearInsertedRows();
}