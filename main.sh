php main.php

DAY=`cat info.json | jq -r '.date'`
BUCKET=$1
gzip -f character_log.json
aws s3 cp character_log.json.gz s3://${BUCKET}/tables/character_log/log_date=${DAY}/character_log.json.gz
gzip -f sell_log.json
aws s3 cp sell_log.json.gz s3://${BUCKET}/tables/sell_log/log_date=${DAY}/sell_log.json.gz
