from pyes import *
from datetime import datetime
import pymysql


def format_time(key):
    if key is None:
        return None

    if isinstance(key, long) or isinstance(key, int):
        key = datetime.fromtimestamp(key)

    return key.strftime('%Y-%m-%d %H:%m:%S')


def query_to_dict(row):
    ret = dict(id=row[0], status=status_to_string(row[1]), title=row[2], body=row[4])

    print row

    optional_fields = {
        'author_username': row[5],
        'author_fullname': row[6],
        'submitted': format_time(row[7]),
        'duedate': format_time(row[8])
    }

    for field, val in optional_fields.iteritems():
        if val is not None:
            ret[field] = val

    return ret


def status_to_string(status_id):
    options = {
        68: 'Unassigned',
        62: 'In Progress',
        63: 'Ready for Review',
        64: 'Accepted by Editor'
    }

    return options.get(status_id, 'Unknown')

conn = pymysql.connect(host='127.0.0.1', user='root', db='writer_portal', charset='utf8')
cur = conn.cursor()
esconn = ES('173.199.132.44:9200')

res = cur.execute('SELECT nid, s.field_status_tid, title, node.uid, b.body_value, '
                  'u.name, n.field_full_name_value, d.field_assigned_on_value, '
                  'duedate.field_due_date_value '
                  'FROM node '
                  'INNER JOIN field_data_body b ON b.entity_id=node.nid and b.entity_type="node" '
                  'LEFT JOIN field_data_field_assigned_to w ON w.entity_id=node.nid '
                  'LEFT JOIN users u ON u.uid=w.field_assigned_to_target_id '
                  'LEFT JOIN field_data_field_full_name n ON n.entity_id=w.field_assigned_to_target_id '
                  'INNER JOIN field_data_field_status s ON s.entity_id=node.nid '
                  'INNER JOIN field_data_field_assigned_on d ON d.entity_id=node.nid '
                  'LEFT JOIN field_data_field_due_date duedate ON duedate.entity_id=node.nid '
                  'WHERE node.type="guest_post"')
for r in cur.fetchall():
    post = query_to_dict(r)
    print post
    esconn.index(post, "writerportal", "article_request", post['id'])






