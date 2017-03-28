<?php
namespace Socket\Lib;

class RedisDb
{
    public static $reObj = null;

    public static function instance()
    {
        if (self::$reObj === null) {
            if (self::connect() !== true) {
                return false;
            }
        }

        return self::$reObj;
    }


    public static function connect()
    {
        self::reset(); //初始化

        if (!extension_loaded('redis')) {
            Log::write('服务器不支持redis扩展');
            return false;
        }

        $config = Config::get('redis');
        $host = $config['host'];
        $port = $config['port'];
        $auth = $config['auth'];
        $db_name = $config['db_name'];

        $re_obj = new \redis();
        $connect = $re_obj->connect($host, $port);

        if ($connect !== true) {
            Log::write('设置redis服务器失败');
            return false;
        }

        if (!empty($auth)) {
            try {
                $re_obj->auth($auth);
            } catch (\Exception $e) {
                Log::write('redis密码错误或连接错误!错误信息:' . $e->getMessage());
                return false;
            }
        }


        try {
            $re_obj->ping();
        } catch (\Exception $e) {
            Log::write('redis连接错误!错误信息:' . $e->getMessage());
            return false;
        }

        $re_obj->select($db_name);
        self::$reObj = $re_obj;
        return true;
    }

    public static function reset()
    {
        self::$reObj = null;
    }

    public static function select($db)
    {
        self::$reObj->select($db);
        return self::$reObj;
    }

    /**
     * 设置值
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param int $timeOut 时间
     */
    public static function set($key, $value, $timeOut = 0, $serialize = true)
    {
        if ($serialize) {
            $value = serialize($value);
        }

        $retRes = self::$reObj->set($key, $value);
        if ($timeOut > 0) self::$reObj->setTimeout($key, $timeOut);
        return $retRes;
    }

    /**
     * 同时设置多值
     * 当发现同名的key存在时，用新值覆盖旧值
     * @param array $value 设置的键值和值组成的数组   ['aaa'=>'123'];
     * @param int $timeOut 时间
     */
    public static function multiSet($value)
    {
        foreach ($value as $key => $a) {
            $value[$key] = serialize($a);
        }

        $value = serialize($value);
        $retRes = self::$reObj->mset($value);
        return $retRes;
    }

    /**
     * 追加字符串
     * @param str $key
     * @param str $valuse
     */
    public static function appendStr($key, $value)
    {
        $retRes = self::$reObj->append($key, $value);
        return $retRes;
    }

    /**
     * 通过KEY获取数据
     * @param string $key KEY名称
     */
    public static function get($key)
    {
        $result = self::$reObj->get($key);

        if (@unserialize($result)) {         //判断是否需要反序列
            return unserialize($result);
        } else {
            return $result;
        }
    }

    /**
     * 通过KEY获取数据
     * @param string $key KEY名称
     */
    public static function rename($key, $newKey)
    {
        $result = self::$reObj->rename($key, $newKey);
        return $result;
    }

    /**
     * 删除一条数据(string)
     * @param string ｜array $key KEY名称
     */
    public static function delete($key)
    {
        return self::$reObj->del($key);
    }

    /**
     * 清空所有数据库数据
     */
    public static function flushAll()
    {
        return self::$reObj->flushAll();
    }

    /**
     * 清空当前数据库数据
     */
    public static function flushDB()
    {
        return self::$reObj->flushDB();
    }

    /**
     * 数据入队列
     * @param string $key KEY名称
     * @param string|array $value 获取得到的数据
     * @param bool $serialize 是否作序列化处理，默认true
     * @param bool $right 是否插到表尾，默认true
     */
    public static function push($key, $value, $serialize = true, $right = true)
    {
        if ($serialize) {
            $value = serialize($value);
        }
        return $right ? self::$reObj->rPush($key, $value) : self::$reObj->lPush($key, $value);
    }

    /**
     * 数据出队列
     * @param string $key KEY名称
     * @param bool $left 是否从左边开始出数据
     */
    public static function pop($key, $left = true)
    {
        $val = $left ? self::$reObj->lPop($key) : self::$reObj->rPop($key);
        return json_decode($val);
    }

    /**
     * 数据出队列（监听）
     * @param string $key KEY名称
     * @param int $timeout 超时
     */
    public static function blPop($key, $timeout = 0)
    {
        return self::$reObj->blPop($key, $timeout);
    }

    /**
     * 返回列表长度
     * @param $key
     * @return mixed
     */
    public static function llen($key)
    {
        return self::$reObj->llen($key);
    }

    /**
     * 返回列表key中指定区间内的元素，区间以偏移量start和stop指定。
     * @param $key
     * @return mixed
     */
    public static function lrange($key, $start, $stop)
    {
        return self::$reObj->lrange($key, $start, $stop);
    }

    /**
     * 根据参数count的值，移除列表中与参数value相等的元素。
     * count的值可以是以下几种：
     * count > 0: 从表头开始向表尾搜索，移除与value相等的元素，数量为count。
     * count < 0: 从表尾开始向表头搜索，移除与value相等的元素，数量为count的绝对值。
     * count = 0: 移除表中所有与value相等的值。
     * @param $key
     * @return mixed
     */
    public static function lrem($key, $value, $count)
    {
        return self::$reObj->lrem($key, $value, $count);
    }

    /**
     * 数据自增
     * @param string $key KEY名称
     */
    public static function increment($key)
    {
        return self::$reObj->incr($key);
    }

    /**
     * 数据增长
     * @param string $key KEY名称
     */
    public static function incrementBy($key, $num)
    {
        return self::$reObj->incrBy($key, $num);
    }

    /**
     * 数据自减
     * @param string $key KEY名称
     */
    public static function decrement($key)
    {
        return self::$reObj->decr($key);
    }

    /**
     * 数据减少
     * @param string $key KEY名称
     */
    public static function decrementBy($key, $num)
    {
        return self::$reObj->decrBy($key, $num);
    }

    /**
     * key是否存在，存在返回ture
     * @param string $key KEY名称
     */
    public static function exists($key)
    {
        return self::$reObj->exists($key);
    }

    /**
     * redis服务器信息
     */
    public static function info()
    {
        return self::$reObj->info();
    }

    /**
     * 构建一个集合(无序集合)
     * @param string $key 集合Y名称
     * @param string|array $value 值
     */
    public static function sadd($key, $value)
    {
        return self::$reObj->sadd($key, $value);
    }

    /**
     * 删除一个集合(无序集合)
     * @param string $key 集合名称
     * @param string|array $value 值
     */
    public static function sRem($key, $value)
    {
        return self::$reObj->sRem($key, $value);
    }

    /**
     * 返回集合key中的所有成员。
     * @param string $setName 集合名字
     */
    public static function sMembers($setName)
    {
        return self::$reObj->smembers($setName);
    }

    /**
     * 判断member元素是否是集合key的成员。
     * @param string $setName 集合名字
     * @param string $member 成员
     */
    public static function sisMembers($setName, $member)
    {
        return self::$reObj->sismember($setName, $member);
    }

    /**
     * 返回集合key的基数(集合中元素的数量)。
     * @param string $setName 集合名字
     */
    public static function sCard($setName)
    {
        return self::$reObj->scard($setName);
    }

    /**
     * 构建一个集合(有序集合)
     * @param string $key 集合名称
     * @param string|array $value 值
     */
    public static function zadd($key, $value, $score)
    {
        return self::$reObj->zadd($key, $score, $value);
    }

    /**
     * 删除一个集合(有序集合)
     * @param string $key 集合名称
     * @param string|array $value 值
     */
    public static function zRem($key, $value)
    {
        return self::$reObj->zRem($key, $value);
    }

    /**
     * 构建一个集合(有序集合),自增scorce
     * @param string $key 集合名称
     * @param string $value 键值
     * @param string $score 值 （score值可以是整数值或双精度浮点数。）
     * @return member成员的新score值，以字符串形式表示。
     */
    public static function zincrby($key, $value, $score)
    {
        return self::$reObj->zincrby($key, $score, $value);
    }

    /**
     * 返回一个有序集合中，value的score
     * @param string $key 集合名称
     * @param string $value 值
     */
    public static function zScore($key, $value)
    {
        return self::$reObj->zScore($key, $value);
    }

    /**
     * 返回一个有序集合中总数
     * @param string $key 集合名称
     */
    public static function zSize($key)
    {
        return self::$reObj->zSize($key);
    }

    /**
     * 返回名称为key的zset（元素已按score从大到小排序）中的index从start到end的所有元素.
     * @param unknown $key
     * @param unknown $start
     * @param unknown $end
     * @param string $withscores 是否输出socre的值，默认false，不输出
     */
    public static function zRevRange($key, $start, $end, $withscores = false)
    {
        return self::$reObj->zRevRange($key, $start, $end, $withscores);
    }



    /** HASH类型 */

    /**
     * 设置hash 一个字段
     * @param string $key 表名字key
     * @param string $key 字段名字
     * @param sting $value 值
     */
    public static function hset($key, $field, $value)
    {
        return self::$reObj->hset($key, $field, $value);
    }

    /**
     * 返回hash表 增加一个元素,但不能重复
     * @param string $key 表名字key
     */
    public static function hsetnx($key, $field, $value)
    {
        return self::$reObj->hsetnx($key, $field, $value);
    }

    /**
     * hash表 增加一个元素多个字段
     * @param string $key 表名字key
     * @param array $fieldAndValue
     * @example ('hash1',array('key3'=>'v3','key4'=>'v4')
     */
    public static function hmset($key, $field)
    {
        return self::$reObj->hmset($key, $field);
    }

    /**
     * 获取hash一个字段的值
     * @param string $key 表名字key
     * @param string $key 表名字key
     * @param string $key 字段名字
     */
    public static function hget($key, $field)
    {
        return self::$reObj->hget($key, $field);
    }

    /**
     * 获取hash多个个字段的值
     * @param array $key 字段名字
     * @example array(‘key3′,’key4′)
     */
    public static function hmget($key, $field)
    {
        return self::$reObj->hmget($key, $field);
    }

    /**
     * 返回hash表中的指定$field是否存在
     * @param string $key 表名字key
     * @param string $key 字段名字
     */
    public static function hexists($key, $field)
    {
        return self::$reObj->hexists($key, $field);
    }

    /**
     * 删除hash表中指定$field的元素
     * @param string $key 表名字key
     * @param string $key 字段名字
     */
    public static function hdel($key, $field)
    {
        return self::$reObj->hdel($key, $field);
    }

    /**
     * 返回hash表元素个数
     * @param string $key 表名字key
     */
    public static function hlen($key)
    {
        return self::$reObj->hdel($key);
    }

    /**
     * hash 对指定key进行累加
     * @param string $key 表名字key
     * @param string $field 表名字key
     * @param Number $num 表名字key
     */
    public static function hincrby($key, $field, $num)
    {
        return self::$reObj->hincrby($key, $field, $num);
    }

    /**
     * hash 返回hash表中的所有field
     * @param string $key 表名字key
     * @return 返回array(‘key1′,’key2′,’key3′,’key4′,’key5′)
     */
    public static function hkeys($key)
    {
        return self::$reObj->hkeys($key);
    }

    /**
     * hash 返回hash表中的所有value
     * @param string $key 表名字key
     * @return //返回array(‘v1′,’v2′,’v3′,’v4′,13)
     */
    public static function hvals($key)
    {
        return self::$reObj->hvals($key);
    }

    /**
     * hash 返回整个hash表元素
     * @param string $key 表名字key
     * @return //返回array(‘key1′=>’v1′,’key2′=>’v2′,’key3′=>’v3′,’key4′=>’v4′,’key5′=>13)
     */
    public static function hgetall($key)
    {
        return self::$reObj->hgetall($key);
    }

    //--------订阅

    /**
     * 将信息 message 发送到指定的频道 channel
     * @param unknown $channel 发送频道
     * @param unknown $msg 发送的消息
     */
    public static function publish($channel, $msg)
    {
        return self::$reObj->publish($channel, $msg);
    }

    /**
     * 将信息 message 发送到指定的频道 channel
     * @param array $channel 发送频道
     * @param function $msg 发送的消息
     */
    public static function subscribe($channel, $function)
    {
        $result = self::$reObj->subscribe($channel, $function);
        return $result;
    }

    /**
     * 监视一个(或多个) key
     */
    public static function watch($key)
    {
        return self::$reObj->watch($key);
    }

    /**
     * 取消监视一个(或多个) key
     */
    public static function unwatch($key)
    {
        return self::$reObj->unwatch($key);
    }

    /**
     * 开启事务
     */
    public static function multi()
    {
        return self::$reObj->multi();
    }

    /**
     * 提交事务
     */
    public static function exec()
    {
        return self::$reObj->exec();
    }

    /**
     * 放弃事务
     */
    public static function discard()
    {
        return self::$reObj->discard();
    }

    /**
     * @param unknown $key
     * @param unknown $option
     * array(
     *  ‘by’ => ‘some_pattern_*’,
     *  ‘limit’ => array(0, 1),
     *  ‘get’ => ‘some_other_pattern_*’ or an array of patterns,
     *  ‘sort’ => ‘asc’ or ‘desc’,
     *  ‘alpha’ => TRUE,
     *  ‘store’ => ‘external-key’
     *  )
     */
    public static function sort($key, $option)
    {
        return self::$reObj->sort($key, $option);
    }

}