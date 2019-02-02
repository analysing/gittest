import redis
# import sys
import MySQLdb

db = MySQLdb.connect('127.0.0.1', 'root', 'root', 'yii2advanced', charset = 'utf8')
cursor = db.cursor() # 使用cursor()方法获取操作游标
sql = 'select * from user where id = 1'
try:
    cursor.execute(sql)
    res = cursor.fetchall()
    for i in res:
        print 'username=%s, email=%s' % (i[1], i[5])
        print 'hahaha...'
except:
    print 'error: unable to fetch data'
db.close()

# r = redis.Redis(host='192.168.20.107', port=6379, password='ivy1234', db=0, decode_responses=True)
pool = redis.ConnectionPool(host='192.168.20.107', port=6379, password='ivy1234', db=0, decode_responses=True)
r = redis.Redis(connection_pool = pool)

r.set('name', 'abiu')
print 'hello '+ r.get('name')
