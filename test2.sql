select 
u.*

from users as u

inner join objects as o on o.id = u.object_id

where u.object_id = 999