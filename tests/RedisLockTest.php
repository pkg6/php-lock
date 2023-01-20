<?php


namespace Pkg6\Lock\Test;

use PHPUnit\Framework\TestCase;
use Pkg6\Lock\Lock;
use Pkg6\Lock\RedisLock;

class RedisLockTest extends TestCase
{
    public function testRedisLock()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        $lock2 = new RedisLock('test', $redis);

        try {
            if (Lock::LOCK_RESULT_SUCCESS === $lock2->lock()) {
                $this->filePutContents('./redis_lock.log');
                $lock2->unlock();
            }
        } catch (\Exception $e) {
        }
        $this->assertEquals(true, is_file('./redis_lock.log'));
    }

    public function filePutContents($file)
    {
        file_put_contents($file, time().PHP_EOL, FILE_APPEND);
    }
}
