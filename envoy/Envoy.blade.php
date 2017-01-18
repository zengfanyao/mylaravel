#登录汉子开发服务器
@servers(['web' => 'root@112.74.49.99'])

@task('foo', ['on' => 'web'])

echo {{ $name }}

cd /disk2/www
mkdir {{ $name }}
cd {{ $name }}

git clone hzf@hzcdn.ping-qu.com:/disk2/git/laravel_framework.git



@endtask


