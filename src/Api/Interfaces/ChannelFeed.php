<?php

interface ChannelFeed
{
    public function getFeedPost($channel_id, $post_id, $access_token, $comments);
    public function getMultipleFeedPosts($channel_id, $access_token, $limit, $cursor, $comments);

    public function createFeedPost($channel_id, $access_token, $content, $share);
    public function deleteFeedPost($channel_id, $post_id, $access_token);

    public function createFeedPostReaction($channel_id, $post_id, $access_token, $emote_id);
    public function deleteFeedPostReaction($channel_id, $post_id, $access_token, $emote_id);

    public function getFeedComments($channel_id, $post_id, $access_token, $limit, $cursor);
    public function createFeedComment($channel_id, $post_id, $access_token, $comment);
    public function deleteFeedComment($channel_id, $post_id, $commentId, $access_token);
    
    public function createFeedCommentReaction($channel_id, $post_id, $commentId, $access_token, $emote_id);
    public function deleteFeedCommentReaction($channel_id, $post_id, $commentId, $access_token, $emote_id);
}