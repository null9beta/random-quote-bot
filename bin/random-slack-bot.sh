#!/bin/bash
#
# wrapper to only trigger random-bot on a certain percentage
#
# usage:
#   ./random-slack-bot.sh <percentage>
#   ./random-slack-bot.sh 20
#
# e.g. in crontab:
#   */10 8-19 * * * /<ABSOLUTE_PATH>/bin/random-slack-bot.sh 20
#
set -e

CONFIG_NAME="main"
CHANNEL_NAME="random-spam-deluxe"


# get the absolute script path
pushd `dirname $0` > /dev/null
SCRIPTPATH=`pwd -P`
popd > /dev/null


percentage="$1"
[ -z "$percentage" ] && percentage=100

rand=$(( ( RANDOM % 100 )  + 1 ))

if [ $rand -le $percentage ]; then
  ${SCRIPTPATH}/console quote:send-random-quote-to-slack "${CONFIG_NAME}" "${CHANNEL_NAME}"
fi

exit 0
